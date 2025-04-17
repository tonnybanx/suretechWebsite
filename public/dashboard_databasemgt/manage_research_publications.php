<?php
require 'database_connection.php';




try {
    $action = $_GET['action'] ?? '';
  switch ($action) {

//adding project areas into the database
    case 'add_publication':
        
            $title = $_POST['title'] ;
            $description = $_POST['content'] ;
            $link = $_POST['link'] ;
            $author = $_POST['author'] ;
            $date = $_POST['date'] ;
        

    try{


    if ($title && $description && $link && $author && $date) {
        $stmt = $pdo->prepare("INSERT INTO publications (title, link, description, author, publisher_date) VALUES (:title, :link, :description, :author, :date)");
        $stmt->execute([
            'title' => $title,
            'link' => $link,
            'description' =>$description,
            'author' =>$author,
            'date' =>$date
        ]);
        // echo "Content uploaded successfully.";
    } else {
                // echo 'Failed to add content into the database';
    }
    }
    catch(PDOException $e){
                // echo "error occurred:" . $e->getMessage();
    }
    
    //header("Location: ../dashboard_research.php");
            break;



//fetching project areas into the database
        case 'fetch_publications':
            $category = 'areas';
        try {
        $stmt = $pdo->prepare("SELECT id, title, description, author, link, publisher_date FROM publications "); 
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($data);
        } catch (PDOException $e) {
    
        echo json_encode(["error" => "Failed to fetch data: " . $e->getMessage()]);
    }
    break;



//updating values of the  project areas tab
        case 'update_publication':
            
            $id = $_POST['id'] ?? '';
            $title = $_POST['title'] ;
            $description = $_POST['content'] ;
            $link = $_POST['link'] ;
            $author = $_POST['author'] ;
            $date = $_POST['date'] ;
            

            if ($id && $title && $description && $link && $author && $date) {
                $stmt = $pdo->prepare("UPDATE publications SET description = :description, title = :title, link = :link, author = :author, publisher_date = :date WHERE id = :id");
                $stmt->execute([
                    'title' => $title,
                    'description' => $description,
                    'id' => $id,
                    'link' => $link,
                    'date' => $date,
                    'author' => $author

                ]);
                // echo "updated";
            } else {
                // echo "invalid update input";
            }
            break;




        case 'delete_publication':
            $id = $_POST['id'] ?? 0;
            
            if ($id) {
                $stmt = $pdo->prepare("DELETE FROM publications WHERE id = :id");
                $stmt->execute(['id' => $id]);
                // echo "deleted";
            } else {
                // echo "invalid delete input";
            }
            

            
            break;




        default:
            echo $action;
            break;
    }

} catch (PDOException $e) {
    error_log($e->getMessage());
    // echo "An error occurred";
}
?>
