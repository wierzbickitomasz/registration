<?php 

class Validator {

  private $data;
  private $errors = [];
  private static $fields = ['name', 'surname', 'email', 'password1', 'password2', 'agreement'];

  public function __construct($data){
    $this->data = $data;
  }
  public function getData(){
    return $this->data;
  }
  public function validateForm(){

    $this->validateName();
    $this->validateSurname();
    $this->validateEmail();
    $this->validatePassword1();
    $this->validatePassword2();
    $this->validateAgreement();
    return $this->errors;

  }

  private function validateName(){

    $val = trim($this->data['name']);

    if(empty($val)){
      $this->addError('name', 'Imie nie może być puste');
    } else {
      if(!preg_match("/^[\p{L} '-]+$/", $val)){
        $this->addError('name','Imie musi się składać z samych liter');
      }
    }

  }
  private function validateSurname(){

    $val = trim($this->data['surname']);

    if(empty($val)){
      $this->addError('surname', 'Nazwisko nie może być puste');
    } else {
      if(!preg_match("/^[\p{L} '-]+$/", $val)){
        $this->addError('surname','Nazwisko musi się składać z samych liter');
      }
    }

  }

  private function validateEmail(){

    $val = trim($this->data['email']);

    if(empty($val)){
      $this->addError('email', 'Email nie może być pusty');
    } else {
      if(!filter_var($val, FILTER_VALIDATE_EMAIL)){
        $this->addError('email', 'Email musi być w odpowiednim formacie');
      }
    }

  }

  private function validatePassword1(){

    $val1 = trim($this->data['password1']);
    $val2 = trim($this->data['password2']);
    //$numberOfDigits = preg_match_all( "/[0-9]/", $val1 );
    $stringLenght = strlen($val1);
    if(empty($val1)){
      $this->addError('password1', 'Hasło nie może być puste');
    } else {
      if($val1 != $val2) {
        $this->addError('password1','Hasła są różne');
      }
      if(($stringLenght < 7)) { 
        $this->addError('password1','Hasło musi spełniać wymagania: min. 7 znaków, min. 1 duża litera, min. 1 mała litera, 1 znak specjalny');
      }
      if((!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{9,99}$/', $val1))){
        $this->addError('password1','Hasło musi spełniać wymagania: min. 7 znaków, min. 1 duża litera, min. 1 mała litera, 1 znak specjalny');
      }
      if(!(preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $val1))){
        $this->addError('password1','Hasło musi spełniać wymagania: min. 7 znaków, min. 1 duża litera, min. 1 mała litera, 1 znak specjalny');
       }
    }

  }

  private function validatePassword2(){

    $val1 = trim($this->data['password1']);
    $val2 = trim($this->data['password2']);
    //$numberOfDigits = preg_match_all( "/[0-9]/", $val2 );
    $stringLenght = strlen($val2);
    if(empty($val2)){
      $this->addError('password2', 'Powtórz hasło');
    } else {
      if($val1 != $val2) {
        $this->addError('password2','Hasła są różne');
      }
      if(($stringLenght < 7)) { 
        $this->addError('password1','Hasło musi spełniać wymagania: min. 7 znaków, min. 1 duża litera, min. 1 mała litera, 1 znak specjalny');
      }
      if((!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{9,99}$/', $val2))){
        $this->addError('password1','Hasło musi spełniać wymagania: min. 7 znaków, min. 1 duża litera, min. 1 mała litera, 1 znak specjalny');
      }
      if(!(preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $val2))){
        $this->addError('password1','Hasło musi spełniać wymagania: min. 7 znaków, min. 1 duża litera, min. 1 mała litera, 1 znak specjalny');
       }
    }

  }

  private function validateAgreement(){

    $val = isset($this->data['agreement']);
    if(!$val) {
      $this->addError('password2','Zaakceptuj warunki');
    }

  }
  

  private function addError($key, $val){
    $this->errors[$key] = $val;
  }

}

?>