<?php
require 'database_connection.php';



function getImagePath(){
$uploadDir = 'images/';
$targetFile = '';
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // create dir if not exists
        }

        $fileName = basename($_FILES['image']['name']);
        $filePath = $uploadDir . $fileName;
       
        if (file_exists($filePath)) {
            $targetFile = $filePath;
         }
          else {
             $targetFile = $uploadDir . uniqid() . "_" . $fileName;
         if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            
           // echo "image upload successfull";
        } else {
                    // echo "Failed to upload image";
        }
         }

        
    }

    return $targetFile;
}


try {
    $action = $_GET['action'] ?? '';
  switch ($action) {

//adding project areas into the database
    case 'addEvent':
            $title = $_POST['title'] ;
            $date = $_POST['date'] ;
            $details = $_POST['details'] ;
            $location = $_POST['location'] ;
            $imagePath = '';
            $imagePath = getImagePath();
            $category = $_POST['category'] ;
    

    if ($title && $imagePath && $date && $location && $details ) {
        $stmt = $pdo->prepare("INSERT INTO events (image_path, title, date, location, category, details) VALUES (:imagePath, :title, :date, :location, :category, :details)");
        $stmt->execute([
            'imagePath' => $imagePath,
            'title' =>$title,
            'date' => $date,
            'category' =>$category,
            'details' =>$details,
            'location' => $location
        ]);
        // echo "Content uploaded successfully.";
    } else {
                // echo 'Failed to add content into the database';
    }
header("Location: ../dashboard_events.php?message=Added successfully &status=successful"); 
    //header("Location: ../dashboard_research.php");
            break;

//adding project areas into the database
    case 'addNews':
           try{
             $title = $_POST['title'] ;
            $details = $_POST['details'] ;
            $imagePath = '';
            $imagePath = getImagePath();
            $category = 'news';
    

    if ($title && $imagePath && $category && $details) {
        $stmt = $pdo->prepare("INSERT INTO events (image_path, title, category, details) VALUES (:imagePath, :title, :category, :details)");
        $stmt->execute([
            'title' => $title,
            'imagePath' => $imagePath,
            'category' =>$category,
            'details' =>$details,
            
        ]);
    
    } 
      header("Location: ../dashboard_events.php?message=Added successfully &status=successful"); 

           }
           catch(PDOException $e){
        header("Location: ../dashboard_events.php?message=An error occurred &status=successful"); 
           }

            break;


//fetching project areas into the database
        case 'fetchConferences':
            $category = 'conference';
        try {
        $stmt = $pdo->prepare("SELECT id, title, image_path, details, location, date  FROM events WHERE category= :category"); 
        $stmt->execute([
            'category' =>$category
        ]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($data);
        } catch (PDOException $e) {
    
        echo json_encode(["error" => "Failed to fetch data: " . $e->getMessage()]);
    }
    break;

//fetching project areas into the database
        case 'fetchHackathrons':
            $category = 'hackathron';
        try {
        $stmt = $pdo->prepare("SELECT id, title, image_path, details, location, date  FROM events WHERE category= :category"); 
        $stmt->execute([
            'category' =>$category
        ]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($data);
        } catch (PDOException $e) {
    
        echo json_encode(["error" => "Failed to fetch data: " . $e->getMessage()]);
    }
    break;

//fetching project areas into the database
        case 'fetchNews':
            $category = 'news';
        try {
        $stmt = $pdo->prepare("SELECT id, title, image_path, details FROM events WHERE category= :category"); 
        $stmt->execute([
            'category' =>$category
        ]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($data);
        } catch (PDOException $e) {
    
        echo json_encode(["error" => "Failed to fetch data: " . $e->getMessage()]);
    }
    break;



//updating values of the  project areas tab
        case 'editEvent':
            
            $title = $_POST['title'] ?? '';
            $location = $_POST['location'] ?? '';
            $details =$_POST['details'] ?? '';
            $id =$_POST['id'] ?? '';
            $date = $_POST['date'] ?? '';
            $image_path=getImagePath();
            

            if ($image_path ) {
                $stmt = $pdo->prepare("UPDATE event SET title =:title, location=:location,details=:details, image_path = :image_path, date=:date WHERE id = :id");
                $stmt->execute([
                    'title' => $title,
                    'location' => $location,
                    'details' => $details,
                    'image_path' =>$image_path,
                    'date' => $privilege,
                    'id' => $id
                ]);
                header("Location: ../dashboard_events.php?message=Update successful&status=successful"); 
            
            } else {
                $stmt = $pdo->prepare("UPDATE event SET title =:title, location=:location,details=:details, date=:date WHERE id = :id");
                $stmt->execute([
                    'title' => $title,
                    'location' => $location,
                    'details' => $details,
                    'date' => $privilege,
                    'id' => $id
                ]);
                header("Location: ../dashboard_events.php?message=Update successful&status=successful"); 
            
            }
            break;

//updating values of the  project areas tab
        case 'editNews':
            
            $title = $_POST['title'] ?? '';
            $details =$_POST['details'] ?? '';
            $id =$_POST['id'] ?? '';
            $image_path=getImagePath();
            

            if ($image_path ) {
                $stmt = $pdo->prepare("UPDATE event SET title =:title, details=:details, image_path = :image_path WHERE id = :id");
                $stmt->execute([
                    'title' => $title,
                    'details' => $details,
                    'image_path' =>$image_path,
                    'id' => $id
                ]);
                // echo "updated";
            } else {
                $stmt = $pdo->prepare("UPDATE event SET title =:title, details=:details  WHERE id = :id");
                $stmt->execute([
                    'title' => $title,
                    'details' => $details,
                    'id' => $id
                ]);
            
            }

            header("Location: ../dashboard_events.php?message=Update successful&status=successful"); 
            break;




        case 'deleteEvent':
            $id = $_POST['id'] ?? 0;

            if ($id) {
                $stmt = $pdo->prepare("DELETE FROM event WHERE id = :id");
                $stmt->execute(['id' => $id]);
                // echo "deleted";
                header("Location: ../dashboard_events.php?message=Deleted successfully &status=successful"); 
            } 
            break;




        default:
            
            break;
    }

} catch (PDOException $e) {
    error_log($e->getMessage());
    // echo "error". $e->getMessage();
    header("Location: ../dashboard_events.php?message=An error occurred &status=unsuccessful"); 
}
?>
