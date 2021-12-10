<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Utility\Message;
use App\Book\Book;
use App\Login\Login;
use App\Borrow\Borrow;
use App\Category\Category;

if(isset($_POST) && $_SERVER['REQUEST_METHOD'] == 'POST'  && Login::loginGet('login') == true){

	if(isset($_POST['dataMethod']) && isset($_POST['dataID']) && $_SERVER['REQUEST_METHOD'] == 'POST'  && Login::loginGet('login') == true && $_POST['dataMethod'] == 'viewBook'){

		$Book = new Book();
		$result = $Book->singleDataById($_POST['dataID']);
		if($result != 'error'){


      if(isset($result['category']) && $result['category'] != ""){
        $strRep = str_replace(',', " ", $result['category']);
        $substr = substr($strRep, 1);
        $explds  = explode(" ", $substr);

        $eachCategory = "";
        $Category = new Category();
        foreach ($explds as $expld) {
          $categoryInfoById = $Category->categoryInfoById($expld);
          if(isset($categoryInfoById) && $categoryInfoById != "error"){
            $eachCategory.='<span class="btn-sm rounded-pill bg-light-gray font-weight-normal mr-2">'.$categoryInfoById['category_name'].'</span>';
          }
        }
      }
      $result['allCategory'] = $eachCategory;

			$loginID = Login::loginGet('id');
			$Borrow = new Borrow;
			$checkBorrow = $Borrow->checkBorrow($_POST['dataID'], $loginID);

			if($checkBorrow != false && $checkBorrow['is_accept'] == 0){
				$result['borrowBtn'] = '<button class="btn btn-sm bg-light-gray mb-5" disabled>Request Sent</button>';

			}else if($checkBorrow != false && $checkBorrow['is_accept'] == 1){
				$result['borrowBtn'] = '<button class="btn btn-sm bg-light-gray mb-5" disabled>Already Borrowed</button>';

			}else{
				$result['borrowBtn'] = '<button class="btn btn-sm btn-primary mb-5" id="borrowNow" data-book_id="'.$result['id'].'" name="borrowbook">Borrow Now</button>';
			}

			echo json_encode($result);
		}else {
			echo "error";
		}
	}else {
		echo "error";
	}

}else{
	header('location:'.WEBROOT.'404.php');
}
