<?php

$db = new \PDO(
            'mysql:host=db.3wa.io;port=3306;dbname=romainaudemar_positit;charset=utf8',
            'romainaudemar',
            '48d823297822bb120c20bdde8982f1f9'
        ); 
        
    $query = 'DELETE FROM positit WHERE created_at < NOW() - INTERVAL 1 MONTH';

    $stmt = $db->prepare($query);
    $stmt->execute();


?>

