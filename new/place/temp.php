<?php
    session_start();

    include("connection.php");
    include("functions.php");

    $user_data=check_login1($con);

    $uid = $_SESSION['uid'];
    //fetch user data from database
    $query = "select * from company where cid={$uid} limit 1";
    $result = mysqli_query($con, $query);
    $cont_query = "select contact from comp_cont where cid={$uid}";
    $cont_res = mysqli_query($con, $cont_query);
    $len = mysqli_num_rows($cont_res);
    if($result){
        $user_data = mysqli_fetch_assoc($result);
        $name = $user_data["NAME"];
        $city = $user_data['CITY'];
        $state = $user_data['STATE'];
        $password = $user_data['PASSWORD'];
    }
    else die;
    if($_SERVER['REQUEST_METHOD']=="POST")
    {   
        //something was posted 
        if(isset($_POST['save_new_cont'])){
            $new = $_POST['new'];
            $new_query = "insert into comp_cont values({$cid}, {$new})";
            mysqli_query($con, $new_query);
            unset($_POST['save_new_cont']);
            $_SESSION['success'] = "Changes successfully saved";
        }
        if(isset($_POST['del_cont'])){
            $del = $_POST['del'];
            $new_query = "delete from student where cid={$uid} and contact={$del}";
            mysqli_query($con, $new_query);
            unset($_POST['del_cont']);
            $_SESSION['success'] = "Changes successfully saved";
        }
    }

?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href='bootstrap/css/bootstrap.min.css'>
	<link rel="stylesheet" href="assets/css/def.css">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<title>Company Dasboard</title>
</head>
<body>
	
	<header class="navbar navbar-expand navbar-dark flex-column flex-md-row shadow text-light" style="background-color:#2818de;">
		<a class="navbar-brand" >Dashboard</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarColor02">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item active">
					<a class="nav-link active-link" href="#">Home
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="jp.php">Job Prerequisites</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="ps.php">Selections</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="logout.php">Logout</a>
				</li>
			</ul>
		</div>
	</header>
	<div class="container-fluid">   
		<div class="row flex-xl-nowrap">
			<main role="main" class="col-12 col-md-9 col-xl-8 py-md-3 pl-md-5 content">
                <h3>Edit Company Info</h3>
                <div style="color: green;">
                    <?php
                        if(isset($_SESSION['success'])){
                            echo $_SESSION['success'];
                            unset($_SESSION['success']);
                        }
                    ?>
                </div>
                <div class="row">
					<button type='button' class='col-1 btn btn-info' id='addBtn'?>Delete Contact</button>
					<div id="addCont" class="modal">
						<div class="modal-dialog" id="m"role="document">
							<div class="modal-content" id="mc">
								<div class="modal-header" id="mh">
									<h5 class="modal-title" id='ch'>Delete Contact</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span class="close" >&times;</span>
									</button>
								</div>
								<div class="modal-body" id="mb">
									<form method = "POST" id="f">
				                        <label for="new">"New contact: </label>
									   <input id="new" type="number" id="new" maxlength="10">
									   <div class="modal-footer">
										<button type="submit" class="btn btn-primary" name="save_new_cont">Add</button>
								        </div>
									</form>
                                </div>
				            </div>
				        </div>
							<script type="text/javascript">
								var modal = document.getElementById("addCont");
								var btn = document.getElementById("addBtn");
								var span = document.getElementsByClassName("close")[0];
								btn.onclick = function() {
									modal.style.display = "block";
								}
								span.onclick = function() {
									modal.style.display = "none";
								}
								window.onclick = function(event) {
									if (event.target == modal) {
										modal.style.display = "none";
									}
								}
							</script>
                    </div>
                    <button type='button' class='col-1 btn btn-info' id='delBtn'?>Add Contact</button>
					<div id="delCont" class="modal" >
						<div class="modal-dialog" id="m"role="document">
							<div class="modal-content" id="mc">
								<div class="modal-header" id="mh">
									<h5 class="modal-title" id='ch'>Delete Contact</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span class="close" >&times;</span>
									</button>
								</div>
								<div class="modal-body" id="mb">
									<form method = "POST" id="f">
				                    <label for="new">"Delete contact: </label>
								    <select name="del" id="del">
                                        <?php
                                            while($number = $cont_res->fetch_row())
                                                echo "<option value='".$data[0]."'>".$data[0]."</option>";
                                        ?>
                                    </select>
                                    <div class="modal-footer">
										<button type="submit" class="btn btn-primary" name="del_cont">Delete</button>
								    </div>
									</form>
                                </div>
				            </div>
				        </div>
                        <script type="text/javascript">
                            var modal = document.getElementById("addCont");
                            var btn = document.getElementById("myBtn");
                            var span = document.getElementsByClassName("close")[0];
                            btn.onclick = function() {
                                modal.style.display = "block";
                            }
                            span.onclick = function() {
                                modal.style.display = "none";
                            }
                            window.onclick = function(event) {
                                if (event.target == modal) {
                                    modal.style.display = "none";
                                }
                            }
                        </script>
				    </div>
                </div>
                <div class="col-6">
                    <form method="POST" action="">
                      <fieldset>
                        <div class="form-group row">
                            <label for="name" class="col-1 col-form-label">Name: </label>
                            <input type="text" readonly="" class="col-2 form-control-plaintext" id="name" value="<?=$name ?>">
                        </div>
                        <div class="form-group row">
                            <label for="idno" class="col-2 col-form-label">City: </label>
                              <input type="text" readonly="" class="col-2 form-control-plaintext" id="idno" value="<?=$city ?>">
                            <label for="branch" class="col-2 col-form-label">State: </label>
                              <input type="text" readonly="" class="col-2 form-control-plaintext" id="branch" value="<?=$state ?>">
                        </div>
                        <br/>
                          
                        <div class="input-group"> 
                            <br>
                            <button name="submit" class="btn btn-info">Save changes</button>
                        </div>
                        </fieldset>
                    </form>
                </div>
            </main>
				</div>
			</div>


			<br>
		</body>
		</html>

