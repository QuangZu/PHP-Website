<?php
// Executes a SQL query with optional parameters
function query($pdo, $sql, $parameters = []) {
    $query = $pdo->prepare($sql);
    $query->execute($parameters);
    return $query;
}

// Count total records in any table
function totalRecords($pdo, $tableName) {
    $query = query($pdo, "SELECT COUNT(*) FROM $tableName");
    $row = $query->fetch();
    return $row[0];
}

function redirectToQuestion($questionid) {
    header("Location: question.php?id=" . urlencode($questionid));
    exit;
}

function getQuestionById($pdo, $questionid, $user_id) {
    $query = 'SELECT * FROM question WHERE questionid = :questionid AND user_id = :user_id';
    $parameters = [
        ':questionid' => $questionid,
        ':user_id' => $user_id
    ];
    return query($pdo, $query, $parameters)->fetch(PDO::FETCH_ASSOC);
}

function getQuestionsByModule($pdo, $moduleName) {
    $query = 'SELECT q.questionid, q.user_id, u.username, u.image, q.questiontitle, q.questiontext, 
                   q.questionimage, q.questionlink, q.questiondate, q.number_like, q.number_comment, q.number_save
            FROM question q
            LEFT JOIN user u ON q.user_id = u.user_id
            INNER JOIN module m ON q.module_id = m.module_id
            WHERE m.module_name = :module_name
            ORDER BY q.questiondate DESC';
    $parameters = ['module_name' => $moduleName];
    return query($pdo, $query, $parameters)->fetchAll(PDO::FETCH_ASSOC);
}

function getQuestionDetails($pdo, $questionid) {
    $query = 'SELECT q.questionid, u.username, u.image, u.role, q.questiontitle, q.questiontext, q.questionimage, 
                   q.questionlink, q.questiondate, q.number_like, q.number_comment, q.number_save
            FROM question q
            LEFT JOIN user u ON q.user_id = u.user_id
            LEFT JOIN module m ON q.module_id = m.module_id
            WHERE q.questionid = :questionid';
    return query($pdo, $query, [':questionid' => $questionid])->fetch();
}

function getAllQuestions($pdo) {
    $query = 'SELECT q.questionid, u.username, u.image, q.questiontitle, q.questiontext, q.questionimage, 
                   q.questionlink, q.questiondate, q.number_like, q.number_comment, q.number_save, m.module_name
            FROM question q
            LEFT JOIN user u ON q.user_id = u.user_id
            LEFT JOIN module m ON q.module_id = m.module_id
            ORDER BY q.questiondate DESC';
    return query($pdo, $query)->fetchAll();
}

function addComment($pdo, $questionid, $user_id, $username, $commentText) {
    $query = 'INSERT INTO comment (questionid, commenttext, user_id, username, commentdate) 
            VALUES (:questionid, :commenttext, :user_id, :username, NOW())';
    return query($pdo, $query, [
        ':questionid' => $questionid,
        ':commenttext' => $commentText,
        ':user_id' => $user_id,
        ':username' => $username
    ]);
}

function deleteComment($pdo, $commentId, $user_id) {
    $query = 'DELETE FROM comment WHERE commentid = :commentid AND user_id = :user_id';
    return query($pdo, $query, [':commentid' => $commentId, ':user_id' => $user_id]);
}

function getCommentsByQuestion($pdo, $questionid) {
    $query = 'SELECT c.*, u.image
            FROM comment c
            LEFT JOIN user u ON c.user_id = u.user_id
            WHERE c.questionid = :questionid
            ORDER BY c.commentdate ASC';
    return query($pdo, $query, [':questionid' => $questionid])->fetchAll();
}

function toggleLike($pdo, $questionid, $user_id) {
    $query = 'SELECT COUNT(*) FROM question_likes WHERE user_id = :user_id AND questionid = :questionid';
    $exists = query($pdo, $query, [':user_id' => $user_id, ':questionid' => $questionid])->fetchColumn();

    if ($exists) {
        query($pdo, 'DELETE FROM question_likes WHERE user_id = :user_id AND questionid = :questionid', 
              [':user_id' => $user_id, ':questionid' => $questionid]);
        query($pdo, 'UPDATE question SET number_like = number_like - 1 WHERE questionid = :questionid', 
              [':questionid' => $questionid]);
    } else {
        query($pdo, 'INSERT INTO question_likes (user_id, questionid) VALUES (:user_id, :questionid)', 
              [':user_id' => $user_id, ':questionid' => $questionid]);
        query($pdo, 'UPDATE question SET number_like = number_like + 1 WHERE questionid = :questionid', 
              [':questionid' => $questionid]);
    }
}

function toggleSave($pdo, $questionid, $user_id) {
    $query = 'SELECT COUNT(*) FROM question_saves WHERE user_id = :user_id AND questionid = :questionid';
    $exists = query($pdo, $query, [':user_id' => $user_id, ':questionid' => $questionid])->fetchColumn();

    if ($exists) {
        query($pdo, 'DELETE FROM question_saves WHERE user_id = :user_id AND questionid = :questionid', 
              [':user_id' => $user_id, ':questionid' => $questionid]);
        query($pdo, 'UPDATE question SET number_save = number_save - 1 WHERE questionid = :questionid', 
              [':questionid' => $questionid]);
    } else {
        query($pdo, 'INSERT INTO question_saves (user_id, questionid) VALUES (:user_id, :questionid)', 
              [':user_id' => $user_id, ':questionid' => $questionid]);
        query($pdo, 'UPDATE question SET number_save = number_save + 1 WHERE questionid = :questionid', 
              [':questionid' => $questionid]);
    }
}

function incrementCommentCount($pdo, $questionid) {
    query($pdo, 'UPDATE question SET number_comment = number_comment + 1 WHERE questionid = :questionid', 
          [':questionid' => $questionid]);
}

function decrementCommentCount($pdo, $questionid) {
    query($pdo, 'UPDATE question SET number_comment = number_comment - 1 WHERE questionid = :questionid', 
          [':questionid' => $questionid]);
}

// Fetch a single user by ID
function getUser($pdo, $user_id) {
    $parameters = [':user_id' => $user_id];
    $query = query($pdo, 'SELECT * FROM user WHERE user_id = :user_id', $parameters);
    return $query->fetch();
}

// Fetch a all users
function getAllUsers($pdo) {
    $query = query($pdo,"SELECT * FROM user WHERE role = 1");
    return $query->fetchAll();
}

// Fetch all modules
function getAllModules($pdo) {
    $query = 'SELECT * FROM module';
    return query($pdo, $query)->fetchAll(PDO::FETCH_ASSOC);
}

function getModulesWithQuestions($pdo) {
    $query = 'SELECT m.module_name, q.questionid, q.user_id, u.username, q.questiontitle, q.questiontext, 
                   q.questionimage, q.questionlink, q.questiondate, q.number_like, q.number_comment
            FROM module m
            LEFT JOIN question q ON m.module_id = q.module_id
            LEFT JOIN user u ON q.user_id = u.user_id
            ORDER BY m.module_name, q.questiondate DESC';
    $modulesWithQuestions = query($pdo, $query)->fetchAll(PDO::FETCH_ASSOC);

    $modules = [];
    foreach ($modulesWithQuestions as $item) {
        $moduleName = $item['module_name'];
        $modules[$moduleName][] = $item;
    }

    return $modules;
}

function getUserPosts($pdo, $user_id) {
    $query = 'SELECT q.questionid, u.username, q.questiontitle, q.questiontext, q.questionimage, q.questionlink, 
                   q.questiondate, q.number_like, q.number_comment, q.number_save, COALESCE(m.module_name, "Unknown Module") AS module_name
            FROM question q
            LEFT JOIN user u ON q.user_id = u.user_id
            LEFT JOIN module m ON q.module_id = m.module_id
            WHERE q.user_id = :user_id
            ORDER BY questiondate DESC';
    return query($pdo, $query, [':user_id' => $user_id])->fetchAll();
}

function getOtherPosts($pdo, $user_id) {
    $query = 'SELECT q.questionid, u.username, q.questiontitle, q.questiontext, q.questionimage, q.questionlink, 
                   q.questiondate, q.number_like, q.number_comment, q.number_save, COALESCE(m.module_name, "Unknown Module") AS module_name
            FROM question q
            LEFT JOIN user u ON q.user_id = u.user_id
            LEFT JOIN module m ON q.module_id = m.module_id
            WHERE q.user_id != :user_id
            ORDER BY questiondate DESC';
    return query($pdo, $query, [':user_id' => $user_id])->fetchAll();
}

function getUserQuestions($pdo, $user_id) {
    $query = 'SELECT q.questionid, q.questiontitle, q.questiontext, q.questionimage, q.questionlink, 
                   q.questiondate, q.number_like, q.number_comment, m.module_name
            FROM question q
            LEFT JOIN module m ON q.module_id = m.module_id
            WHERE q.user_id = :user_id
            ORDER BY q.questiondate DESC';
    return query($pdo, $query, [':user_id' => $user_id])->fetchAll();
}

function getUserSavedQuestions($pdo, $user_id) {
    $query = 'SELECT q.questionid, q.questiontitle, q.questiontext, q.questionimage, q.questionlink, 
                   q.questiondate, q.number_like, q.number_comment, m.module_name
            FROM question q
            LEFT JOIN module m ON q.module_id = m.module_id
            INNER JOIN question_saves qs ON q.questionid = qs.questionid
            WHERE qs.user_id = :user_id
            ORDER BY q.questiondate DESC';
    return query($pdo, $query, [':user_id' => $user_id])->fetchAll();
}

function updateUserImage($pdo, $user_id, $imageName) {
    query($pdo, 'UPDATE user SET image = :image WHERE user_id = :user_id', [':image' => $imageName, ':user_id' => $user_id]);
}

function updateUserName($pdo, $user_id, $newName) {
    query($pdo, 'UPDATE user SET username = :username WHERE user_id = :user_id', [':username' => $newName, ':user_id' => $user_id]);
}

function updateUserEmail($pdo, $user_id, $newEmail) {
    query($pdo, 'UPDATE user SET email = :email WHERE user_id = :user_id', [':email' => $newEmail, ':user_id' => $user_id]);
}

function updateUserPassword($pdo, $user_id, $newPassword) {
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    query($pdo, 'UPDATE user SET password = :password WHERE user_id = :user_id', [':password' => $hashedPassword, ':user_id' => $user_id]);
}

function deleteUserAccount($pdo, $user_id) {
    try {
        $pdo->beginTransaction();
        query($pdo, 'DELETE FROM question WHERE user_id = :user_id', [':user_id' => $user_id]);
        query($pdo, 'DELETE FROM comment WHERE user_id = :user_id', [':user_id' => $user_id]);
        query($pdo, 'DELETE FROM user WHERE user_id = :user_id', [':user_id' => $user_id]);
        $pdo->commit();
        return true;
    } catch (Exception $e) {
        $pdo->rollBack();
        return false;
    }
}

function uploadImage($pdo, $file, $targetDir, $updateQuery = null, $updateParams = [], $currentImagePath = null) {
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

    $imageName = uniqid() . '-' . basename($file['name']);
    $targetFile = $targetDir . $imageName;

    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
        if ($updateQuery && $updateParams) {
            $updateParams['image'] = $imageName;
            $stmt = $pdo->prepare($updateQuery);
            $stmt->execute($updateParams);
        }
        if ($currentImagePath && file_exists($targetDir . $currentImagePath)) {
            unlink($targetDir . $currentImagePath);
        }

        return $imageName;
    }

    return false;
}

// Update a user's information
function updateUser($pdo, $user_id, $username, $email, $image) {
    $query = 'UPDATE user SET username = :username, email = :email, image = :image WHERE user_id = :user_id';
    $parameters = [':username' => $username, ':email' => $email, ':image' => $image, ':user_id' => $user_id];
    query($pdo, $query, $parameters);
}

// Delete a user and their related data
function deleteUser($pdo, $user_id) {
    $parameters = [':user_id' => $user_id];
    query($pdo, 'DELETE FROM comment WHERE user_id = :user_id', $parameters);
    query($pdo, 'DELETE FROM question WHERE user_id = :user_id', $parameters);
    query($pdo, 'DELETE FROM user WHERE user_id = :user_id', $parameters);
}

// Insert a new question
function insertQuestion($pdo, $user_id, $questiontitle, $questiontext, $questionimage, $questionlink, $module_id) {
    $query = 'INSERT INTO question (user_id, questiontitle, questiontext, questionimage, questionlink, questiondate, module_id)
              VALUES (:user_id, :questiontitle, :questiontext, :questionimage, :questionlink, NOW(), :module_id)';
    $parameters = [
        ':user_id' => $user_id,
        ':questiontitle' => $questiontitle,
        ':questiontext' => $questiontext,
        ':questionimage' => $questionimage,
        ':questionlink' => $questionlink,
        ':module_id' => $module_id
    ];
    query($pdo, $query, $parameters);
}

// Update a question's information
function updateQuestion($pdo, $questionid, $questiontitle, $questiontext, $questionimage, $questionlink, $user_id) {
    $query = 'UPDATE question SET questiontitle = :questiontitle, questiontext = :questiontext, questionimage = :questionimage, 
              questionlink = :questionlink WHERE questionid = :questionid AND user_id = :user_id';
    $parameters = [
        ':questiontitle' => $questiontitle,
        ':questiontext' => $questiontext,
        ':questionimage' => $questionimage,
        ':questionlink' => $questionlink,
        ':questionid' => $questionid,
        ':user_id' => $user_id
    ];
    query($pdo, $query, $parameters);
}

// Delete a question and its comments
function deleteQuestion($pdo, $questionid, $user_id, $role) {
    if ($role==2) {
        $query = 'DELETE FROM question WHERE questionid = :questionid';
        $parameters = ['questionid' => $questionid];
    } else {
        $query = 'DELETE FROM question WHERE questionid = :questionid AND user_id = :user_id';
        $parameters = [
            'questionid' => $questionid,
            'user_id' => $user_id
        ];
    }

    query($pdo, $query, $parameters);
}

// Insert a comment
function insertComment($pdo, $questionid, $user_id, $commentText) {
    $query = 'INSERT INTO comment (questionid, user_id, commenttext, commentdate) VALUES (:questionid, :user_id, :commenttext, NOW())';
    $parameters = [':questionid' => $questionid, ':user_id' => $user_id, ':commenttext' => $commentText];
    query($pdo, $query, $parameters);
}

// Update a comment
function updateComment($pdo, $commentID, $commentText) {
    $query = 'UPDATE comment SET commenttext = :commenttext WHERE commentid = :commentid';
    $parameters = [':commenttext' => $commentText, ':commentid' => $commentID];
    query($pdo, $query, $parameters);
}

// Search questions
function searchQuestions($pdo, $searchQuery) {
    $query = "SELECT q.questionid, u.username, u.image, q.questiontitle, q.questiontext, q.questionimage, 
                   q.questionlink, q.questiondate, q.number_like, q.number_comment, q.number_save, m.module_name
            FROM question q
            LEFT JOIN user u ON q.user_id = u.user_id
            LEFT JOIN module m ON q.module_id = m.module_id
            WHERE q.questiontitle LIKE :searchQuery
            ORDER BY q.questiondate DESC";
    return query($pdo, $query, [':searchQuery' => '%' . $searchQuery . '%'])->fetchAll();
}
