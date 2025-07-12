<?php
session_start();
include '../assets/constant/config.php';
 
  
  

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
<?php include('include/sidebar.php'); ?>
<!-- Top Bar End -->
<?php include('include/header.php'); ?>
<div class="page-content-wrapper ">
    <div class="row tittle">

        <div class="top col-md-5 align-self-center">
            <h5>Edit Employee</h5>
        </div>

        <div class="col-md-7  align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Edit Employee</li>
            </ol>
        </div>
    </div>



    <div class="container-fluid">
        <div class="row">
        <!--   -->
            <div class="col-lg-8" style="margin-left: 10%;">
                <div class="card">
                    <div class="card-body">

                        <div class="tab-content">

                            <div class="tab-pane active p-3" id="home" role="tabpanel">


                                <form id="add_employee" method="POST" action="app/employee_crud.php">
                                    <?php
                                    $stmt = $conn->prepare("SELECT * FROM `employee` WHERE id='" . $_POST['id'] . "' ");
                                    $stmt->execute();
                                    $record = $stmt->fetchAll();

                                    foreach ($record as $key) {
                                    ?>

                                        <input class="form-control" type="hidden" name="id" value="<?php echo $key['id']; ?>">
                                        <div class="form-group">
                                            <div class="row">
        <!--   -->
                                                <label class="col-sm-3 control-label">Employee Name</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="employeeName" placeholder="Employee Name" value="<?php echo $key['employeeName'] ?>" name="employeeName">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
        <!--   -->
                                                <label class="col-sm-3 control-label">Email</label>
                                                <div class="col-sm-9">
                                                    <input type="email" class="form-control" id="employeeEmail" placeholder="Employee Email" value="<?php echo $key['employeeEmail'] ?>" name="employeeEmail">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
        <!--   -->
                                                <label class="col-sm-3 control-label">Phone</label>
                                                <div class="col-sm-9">
                                                    <input type="tel" class="form-control" id="employeePhone" placeholder="Employee Phone" value="<?php echo $key['employeePhone'] ?>" name="employeePhone">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
        <!--   -->
                                                <label class="col-sm-3 control-label">AccountNo</label>
                                                <div class="col-sm-9">
                                                    <input type="tel" class="form-control" id="employeeAccountNo" placeholder="Employee Account No" value="<?php echo $key['employeeAccountNo'] ?>" name="employeeAccountNo">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
        <!--   -->
                                                <label class="col-sm-3 control-label">Address</label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control" id="employeeAddress" placeholder="Employee Address" name="employeeAddress"><?php echo $key['employeeAddress']?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
        <!--   -->
                                                <label class="col-sm-3 control-label">shift</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" id="shift" name="shift">
                                                        <option value="">~~SELECT~~</option>
                                                        <option value="Day" <?php if ($key['shift'] == 'Day') echo 'selected="selected"'; ?>>Day</option>
                                                        <option value="Night" <?php if ($key['shift'] == 'Night') echo 'selected="selected"'; ?>>Night</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <button class="btn btn-primary" type="submit" name="update" onclick="validateEmployee()">Submit</button>
                                        </div>

                                    <?php } ?>
                                </form>


                            </div>
                        </div>

                    </div>
                </div><!--end card-->
            </div><!--end col-->
        </div><!--end row-->
    </div> <!-- Page content Wrapper -->
</div> <!-- content -->

<?php include('include/footer.php'); ?>



<script>
    function validateEmployee() {
        // Custom method to check if the input contains only spaces
        $.validator.addMethod("noSpacesOnly", function(value, element) {
            return value.trim() !== '';
        }, "Please enter a non-empty value");

        // Custom method to check if the input contains only alphabet characters
        $.validator.addMethod("lettersonly", function(value, element) {
            return /^[a-zA-Z\s]*$/.test(value);
        }, "Please enter alphabet characters only");

        // Custom method to check if the input contains only digits
        $.validator.addMethod("noDigits", function(value, element) {
            return !/\d/.test(value);
        }, "Please enter a value without digits");

        $('#add_employee').validate({
            rules: {
                employeeName: {
                    required: true,
                    noSpacesOnly: true,
                    lettersonly: true
                },
                employeeEmail: {
                    required: true,
                    email: true
                },
                employeePhone: {
                    required: true,
                    noSpacesOnly: true,
                    digits: true,
                    maxlength: 10,
                    minlength: 10
                },
                employeeAccountNo: {
                    required: true,
                    noSpacesOnly: true,
                    digits: true,
                    minlength: 8
                },
                employeeAddress: {
                    required: true,
                    noSpacesOnly: true
                },
                shift: {
                    required: true
                }
            },
            messages: {
                employeeName: {
                    required: "Please enter a Employee name",
                    lettersonly: "Only alphabet characters are allowed"
                },
                employeeEmail: {
                    required: "Please enter a Employee email",
                    email: "Please enter a valid email address"
                },
                employeePhone: {
                    required: "Please enter a Employee phone number",
                    noDigits: "Employee phone number should not contain digits"
                },
                employeeAccountNo: {
                    required: "Please enter a Employee Account number",
                    noDigits: "Employee Account number should not contain digits"
                },
                employeeAddress: {
                    required: "Please enter a Employee address"
                },
                shift: {
                    required: "Please select a Employee shift"
                }
            }
        });
    }
</script>