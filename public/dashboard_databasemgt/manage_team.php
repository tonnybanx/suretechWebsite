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
            
            
            // echo "<script>console.log('image upload successfull'); </script>";
        } else {
        //    echo "<script>console.log('Failed to upload image'); </script>";     
        }
         }

        
    }

    return $targetFile;
}


try {
    $action = $_GET['action'] ?? '';
  switch ($action) {

//adding project areas into the database
    case 'addStudent':
            $firstName = $_POST['firstName'] ;
            $lastName = $_POST['lastName'] ;
            $details = $_POST['details'] ;
            $privilege = $_POST['privilege'] ;
            $imagePath = '';
            $imagePath = getImagePath();
            $category = 'student';
    

    if ($firstName && $imagePath && $lastName && $imagePath && $details) {
        $stmt = $pdo->prepare("INSERT INTO team (image_path, first_name, last_name, details, category, privilege) VALUES (:imagePath, :firstName, :lastName, :details, :category, :privilege)");
        $stmt->execute([
            'firstName' => $firstName,
            'lastName' =>$lastName,
            'imagePath' => $imagePath,
            'category' =>$category,
            'details' =>$details,
            'privilege' => $privilege
        ]);
        // echo "Content uploaded successfully.";
    } else {
                // echo 'Failed to add content into the database';
    }
    //header("Location: ../dashboard_research.php");
            break;

//adding project areas into the database
    case 'addStaff':
            $firstName = $_POST['firstName'] ;
            $lastName = $_POST['lastName'] ;
            $details = $_POST['details'] ;
            $privilege = $_POST['privilege'] ;
            $imagePath = '';
            $imagePath = getImagePath();
            $category = 'staff';
    

    if ($firstName && $imagePath && $lastName && $imagePath && $details) {
        $stmt = $pdo->prepare("INSERT INTO team (image_path, first_name, last_name, details, category, privilege) VALUES (:imagePath, :firstName, :lastName, :details, :category, :privilege)");
        $stmt->execute([
            'firstName' => $firstName,
            'lastName' =>$lastName,
            'imagePath' => $imagePath,
            'category' =>$category,
            'details' =>$details,
            'privilege' => $privilege
        ]);
        // echo "Content uploaded successfully.";
    } else {
                // echo 'Failed to add content into the database';
    }
    //header("Location: ../dashboard_research.php");
            break;


//fetching project areas into the database
        case 'fetchStudents':
            $category = 'student ';
        try {
        $stmt = $pdo->prepare("SELECT id, first_name, last_name, image_path, details, privilege  FROM team WHERE category= :category"); 
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
        case 'fetchStaff':
            $category = 'staff';
        try {
        $stmt = $pdo->prepare("SELECT id, first_name, last_name, image_path, details, privilege  FROM team WHERE category= :category"); 
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
        case 'editStudent':
            
            $firstName = $_POST['firstName'] ?? '';
            $lastName = $_POST['lastName'] ?? '';
            $details =$_POST['details'] ?? '';
            $id =$_POST['id'] ?? '';
            $privilege = $_POST['privilege'] ?? '';
            $image_path=getImagePath();
            

            if ($image_path ) {
                $stmt = $pdo->prepare("UPDATE team SET first_name =:firstName, last_name=:lastName,details=:details, image_path = :image_path, privilege=:privilege WHERE id = :id");
                $stmt->execute([
                    'firstName' => $firstName,
                    'lastName' => $lastName,
                    'details' => $details,
                    'image_path' =>$image_path,
                    'privilege' => $privilege,
                    'id' => $id
                ]);
                // echo "updated";
            } else {
                $stmt = $pdo->prepare("UPDATE team SET first_name =:firstName, last_name=:lastName,details=:details, privilege=:privilege WHERE id = :id");
                $stmt->execute([
                    'firstName' => $firstName,
                    'lastName' => $lastName,
                    'details' => $details,
                    'privilege' => $privilege,
                    'id' => $id
                ]);
            
            }
            break;




        case 'delete_project':
            $id = $_POST['id'] ?? 0;

            if ($id) {
                $stmt = $pdo->prepare("DELETE FROM content WHERE id = :id");
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
    // echo "error". $e->getMessage();
}
?>
