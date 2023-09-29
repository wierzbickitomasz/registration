<?php 

  require('validator.php');

  $errors = [];

  class User {
    public $name;
    public $surname;
    public $email;
    public $password;
    function __construct($data) {
      $this->name = $data['name']; 
      $this->surname = $data['surname']; 
      $this->email = $data['email']; 
      $this->password = $data['password1']; 
    }
    /*
    function showData() {
      echo " imie: " .  $this->name; echo nl2br("\n"); echo " nazwisko: " .  $this->surname; echo nl2br("\n");   echo " email: " .  $this->email; echo nl2br("\n"); echo " haslo: " .  $this->password; echo nl2br("\n");   
    }
    */
    function register($name, $surname, $email, $password1) {
      $dbname = 'database';
      $servername = "localhost";
      $username = "root";
      $password = "";
      
      // Create connection
      $conn = new mysqli($servername, $username, $password, $dbname);
      // Check connection
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }
      
      $sql = "INSERT INTO users (name, surname, email, password)
      VALUES ('$name', '$surname', '$email', '$password1')";
      if ($conn->query($sql) === TRUE) {
        //echo "New record created successfully";
      } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
      
      $conn->close();
    }

    public static function emailExists($email) {
      $dbname = 'database';
      $servername = "localhost";
      $username = "root";
      $password = "";
      
      // Create connection
      $conn = new mysqli($servername, $username, $password, $dbname);
      // Check connection
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      $sql = "SELECT id FROM users WHERE email= '$email'";
      $result = $conn->query($sql);
      
      if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          //echo "id: " . $row["id"];
        }
        echo "Użytkownik o podanym emailu już istnieje";
        return true;
      } else {
        //echo "0 results";
        return false;
      }
    }
  }

  if(isset($_POST['submit'])){
    $validation = new Validator($_POST);

    $errors = $validation->validateForm();
    $arg = $validation->getData();
    if (empty($errors) && (!User::emailExists($arg['email']))) {
      $user = new User($arg);
      echo "Wprowadzono poprawne dane, utworzono nowego użytkownika";
      echo nl2br("\n");
      //$user->showData();
      $user->register($arg['name'], $arg['surname'], $arg['email'], $arg['password1']);
    }
  }

?>

<html lang="en">
<head>
  <title></title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div id="registration">
    <h1>Rejestracja</h1>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
      <div id="names" style="display: flex">
        <div class="input">
        <label>Imie: </label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($_POST['name']) ?? '' ?>">
        <div class="error">
          <?php echo $errors['name'] ?? '' ?>
        </div>
        </div>
        <div class="input">
        <label>Nazwisko: </label>
        <input type="text" name="surname" value="<?php echo htmlspecialchars($_POST['surname']) ?? '' ?>">
        <div class="error">
          <?php echo $errors['surname'] ?? '' ?>
        </div>
        </div>
      </div>

      <div class="input">
      <label>Email: </label>
      <input type="text" name="email" value="<?php echo htmlspecialchars($_POST['email']) ?? '' ?>">
      <div class="error">
        <?php echo $errors['email'] ?? '' ?>
      </div>
      </div>
      <div class="input">
      <label>Hasło: </label>
      <input type="text" name="password1" value="<?php echo htmlspecialchars($_POST['password1']) ?? '' ?>">
      <div class="error">
        <?php echo $errors['password1'] ?? '' ?>
      </div>
      </div>  
      <div class="input">
      <label>Powtórz hasło: </label>
      <input type="text" name="password2" value="<?php echo htmlspecialchars($_POST['password2']) ?? '' ?>">
      <div class="error">
        <?php echo $errors['password2'] ?? '' ?>
      </div>
      </div>
      <div class="input">
      <div class="agreement">
      <input type="checkbox" id="agreement" name="agreement" value="agreement">
      <label>Akceptuję warunki </label>
      </div>
      </div>
      <input id="submit" type="submit" value="Zarejestruj się" name="submit" >

    </form>
  </div>

</body>
</html>