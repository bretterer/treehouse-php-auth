<?php
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;


/**
 * @return \Symfony\Component\HttpFoundation\Request
 */
function request() {
    return \Symfony\Component\HttpFoundation\Request::createFromGlobals();
}

function redirect($path, $extra = []) {
    $response = Response::create(null, Response::HTTP_FOUND, ['Location' => $path]);

    if(key_exists('cookies', $extra)) {
        foreach($extra['cookies'] as $cookie) {
            $response->headers->setCookie($cookie);
        }
    }

    $response->send();
    exit;
}

function display_errors() {
    global $session;

    if(!$session->getFlashBag()->has('error')) {
        return;
    }

    $errors = $session->getFlashBag()->get('error');

    $response = '<ul>';
    foreach($errors as $error ) {
        $response .= "<li>{$error}</li>";
    }
    $response .= '</ul>';

    return $response;
}

function display_success() {
    global $session;

    if(!$session->getFlashBag()->has('success')) {
        return;
    }

    $messages = $session->getFlashBag()->get('success');

    $response = '<div class="alert alert-success alert-dismissable">';
    foreach($messages as $message ) {
        $response .= "<strong>SUCCESS! </strong> {$message}";
    }
    $response .= '</div>';

    return $response;
}

function addBook($title, $description) {
    global $db;
    $id = accessToken('sub');
    try {
        $stmt = $db->prepare("INSERT INTO books (name, description, owner_id) VALUES (:name, :description, :id)");
        $stmt->bindParam(':name', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    } catch ( \Exception $e ) {
        throw $e;
    }
}

function getBook($id) {
    global $db;

    try {
        $stmt = $db->prepare("SELECT * FROM books WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (\Exception $e) {
        throw $e;
    }
}

function deleteBook($id) {
    global $db;

    try {
        $stmt = $db->prepare("DELETE from books where id = ? ");
        $stmt->execute([$id]);
        return true;
    } catch (\Exception $e) {
        return false;
    }
}

function getAllBooks() {
    global $db;

    $userId = 0;

    if(isAuthenticated()) {
        $userId = accessToken('sub');
    }
    $query = "SELECT books.*, sum(votes.value) as score, (SELECT value FROM votes WHERE votes.book_id=books.id AND votes.user_id={$userId}) as myVote FROM books LEFT JOIN votes ON (books.id = votes.book_id) GROUP BY books.id ORDER BY score DESC";
    try {
        $stmt = $db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch ( \Exception $e ) {
        throw $e;
    }
}

function getMyBooks() {
    global $db;

    $userId = accessToken('sub');

    $query = "SELECT books.*, sum(votes.value) as score, (SELECT value FROM votes WHERE votes.book_id=books.id AND votes.user_id={$userId}) as myVote FROM books LEFT JOIN votes ON (books.id = votes.book_id) WHERE books.owner_id = ? GROUP BY books.id ORDER BY score DESC";

    try {
        $stmt = $db->prepare($query);
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    } catch ( \Exception $e ) {
        throw $e;
    }
}

function findUserByEmail($email) {
    global $db;

    try {
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch ( \Exception $e ) {
        throw $e;
    }
}

function findUserById($id) {
    global $db;

    try {
        $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch ( \Exception $e ) {
        throw $e;
    }
}

function createUser($email, $password) {
    global $db;

    try {
        $stmt = $db->prepare("INSERT INTO users (email, password, role_id) VALUES (:email, :password, 2)");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        return $db->lastInsertId();
    } catch ( \Exception $e ) {
        throw $e;
    }
}

function isAuthenticated() {
    if(!request()->cookies->has('access_token')) {
        return false;
    }

    try {
        \Firebase\JWT\JWT::$leeway = 1;
        $jwt = \Firebase\JWT\JWT::decode(
            request()->cookies->get('access_token'),
            getenv('SECRET_KEY'),
            ['HS256']
        );

        return true;
    } catch (\Exception $e) {
        return false;
    }

}

function requireAuth() {
    if(!isAuthenticated()) {
        $accessToken = new Cookie("access_token", 'EXPIRED', time()-3600, '/', 'php-auth.dev');
        redirect('/login.php', ['cookies' => [$accessToken]]);
    }

    try {
        \Firebase\JWT\JWT::$leeway = 1;
        \Firebase\JWT\JWT::decode(
            request()->cookies->get('access_token'),
            getenv('SECRET_KEY'),
            ['HS256']
        );
    } catch (\Exception $e) {
        $accessToken = new Cookie("access_token", 'EXPIRED', time()-3600, '/', 'php-auth.dev');
        redirect('/login.php', ['cookies' => [$accessToken]]);
    }

}

function isAdmin() {
    if(!isAuthenticated()) {
        return false;
    }

    try {
        \Firebase\JWT\JWT::$leeway = 1;
        $jwt = \Firebase\JWT\JWT::decode(
            request()->cookies->get('access_token'),
            getenv('SECRET_KEY'),
            ['HS256']
        );
    } catch (\Exception $e) {
        return false;
    }

    return $jwt->is_admin;
}

function requireAdmin() {
    if(!isAuthenticated()) {
        $accessToken = new Cookie("access_token", 'EXPIRED', time()-3600, '/', 'php-auth.dev');
        redirect('/login.php', ['cookies' => [$accessToken]]);
    }


    try {
        \Firebase\JWT\JWT::$leeway = 1;
        $jwt = \Firebase\JWT\JWT::decode(
            request()->cookies->get('access_token'),
            getenv('SECRET_KEY'),
            ['HS256']
        );
    } catch (\Exception $e) {
        $accessToken = new Cookie("access_token", 'EXPIRED', time()-3600, '/', 'php-auth.dev');
        redirect('/login.php', ['cookies' => [$accessToken]]);
        exit;
    }

    if(!$jwt->is_admin) {
        redirect('/unauthorized.php');
    }
}

function user($item = null) {
    if(!isAuthenticated()) {
        return false;
    }
    try {
        \Firebase\JWT\JWT::$leeway = 1;
        $jwt = \Firebase\JWT\JWT::decode(
            request()->cookies->get('access_token'),
            getenv('SECRET_KEY'),
            ['HS256']
        );
    } catch (\Exception $e) {
        $accessToken = new Cookie("access_token", 'EXPIRED', time()-3600, '/', 'php-auth.dev');
        redirect('/login.php', ['cookies' => [$accessToken]]);
        exit;
    }

    $user = findUserById($jwt->sub);

    if(!$user) {
        return false;
    }

    if($item) {
        return $user[$item];
    }

    return $user;
}

function accessToken($item = null) {
    if(!isAuthenticated()) {
        return false;
    }
    try {
        \Firebase\JWT\JWT::$leeway = 1;
        $jwt = \Firebase\JWT\JWT::decode(
            request()->cookies->get('access_token'),
            getenv('SECRET_KEY'),
            ['HS256']
        );
    } catch (\Exception $e) {
        return false;
    }

    if($item) {
        return $jwt->{$item};
    }

    return $jwt;
}


function clearVote($book) {
    global $db;

    try {
        $stmt = $db->prepare('DELETE FROM votes WHERE book_id = :bookId AND user_id = :userId');
        $stmt->execute([':bookId' => $book['id'], ':userId' => accessToken('sub')]);

    } catch (\Exception $e) {
    }
}

function voteUp($book) {
    global $db;

    try {
        $stmt = $db->prepare('INSERT INTO votes (book_id, user_id, value) VALUES (:bookId, :userId, 1)');
        $stmt->execute([":bookId"=>$book['id'], ":userId"=>accessToken('sub')]);

    } catch (\Exception $e) {
    }
}

function voteDown($book) {
    global $db;

    try {
        $stmt = $db->prepare('INSERT INTO votes (book_id, user_id, value) VALUES (:bookId, :userId, -1)');
        $stmt->execute([":bookId"=>$book['id'], ":userId"=>accessToken('sub')]);

    } catch (\Exception $e) {
    }
}

function updatePassword($password) {
    global $db;

    try {
        $stmt = $db->prepare('UPDATE users SET password=:password WHERE id = :userId');
        $stmt->execute([":password"=> $password, ":userId"=>accessToken('sub')]);
    } catch (\Exception $e) {
        return false;
    }

    return true;
}

function getAllUsers() {
    global $db;

    try {
        $stmt = $db->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch ( \Exception $e ) {
        throw $e;
    }
}

function promote($user) {
    global $db;

    try {
        $stmt = $db->prepare("UPDATE users SET role_id=1 WHERE id = ?");
        $stmt->execute([$user['id']]);
    } catch (\Exception $e) {
        throw $e;
    }
}

function demote($user) {
    global $db;

    try {
        $stmt = $db->prepare("UPDATE users SET role_id=2 WHERE id = ?");
        $stmt->execute([$user['id']]);
    } catch (\Exception $e) {
        throw $e;
    }
}