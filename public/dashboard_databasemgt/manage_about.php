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
        $targetFile = $uploadDir . uniqid() . "_" . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            echo "image upload successfull";
        } else {
                    echo "Failed to upload image";
        }
    }

    return $targetFile;
}


try {
    $action = $_GET['action'] ?? '';
  switch ($action) {

//adding project areas into the database
    case 'add_project':
            $title = $_POST['areaTitle'] ;
            $description = $_POST['projectDescription'] ;

            $imagePath = '';
            $imagePath = getImagePath();
            $category = 'projects';
    

    if ($title && $imagePath) {
        $stmt = $pdo->prepare("INSERT INTO projects (title, image_path, category, description) VALUES (:title, :image, :category, :description)");
        $stmt->execute([
            'title' => $title,
            'image' => $imagePath,
            'category' =>$category,
            'description' =>$description
        ]);
        echo "Content uploaded successfully.";
    } else {
                echo 'Failed to add content into the database';
    }
    header("Location: ../dashboard_research.php");
            break;

//fetching project areas into the database
        case 'fetch_projects':
            $category = 'projects';
        try {
        $stmt = $pdo->prepare("SELECT id, title, image_path, description FROM projects WHERE category= :category"); 
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
        case 'update_project':
            
            $title = $_POST['areaTitle'] ?? '';
            $description =$_POST['projectDescription'] ?? '';
            $id = $_POST['id'] ?? '';
            $image_path=getImagePath();
            

            if ($id && $title && $image_path) {
                $stmt = $pdo->prepare("UPDATE projects SET image_path = :image_path, title = :title ,description= :description WHERE id = :id");
                $stmt->execute([
                    'title' => $title,
                    'description' => $description,
                    'image_path' =>$image_path,
                    'id' => $id
                ]);
                echo "updated";
            } else {
                echo "invalid update input";
            }
            break;




        case 'delete_project':
            $id = $_POST['id'] ?? 0;

            if ($id) {
                $stmt = $pdo->prepare("DELETE FROM content WHERE id = :id");
                $stmt->execute(['id' => $id]);
                echo "deleted";
            } else {
                echo "invalid delete input";
            }
            break;




        default:
            echo $action;
            break;
    }

} catch (PDOException $e) {
    error_log($e->getMessage());
    echo "error";
}
?>
