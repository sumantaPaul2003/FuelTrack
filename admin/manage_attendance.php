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
    <di class="row tittle">
        <div class="top col-md-5 align-self-center">
            <h5>Employee Attendance</h5>
        </div>
        <div class="col-md-7  align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Employee Attendance</li>
            </ol>
        </div>
    </di v>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8" style="margin-left: 10%;">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active p-3" id="home" role="tabpanel">
                                <form id="mark_attendance" method="POST" action="app/employee_attendance.php">
                                    <div class="form-group">
                                        <label for="attendanceDate">Select Date:</label>
                                        <input type="date" class="form-control" id="attendanceDate"
                                            name="attendanceDate" required>
                                    </div>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Serial Number</th>
                                                <th>Employee Name</th>
                                                <th>Present</th>
                                                <th>Absent</th>
                                                <th>Leave</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Fetch all employees from the database
                                            $employees = $conn->query("SELECT * FROM employee");
                                            $sn = 1;

                                            // Check if the attendance date is set
                                            $attendanceDate = isset($_POST['attendanceDate']) ? $_POST['attendanceDate'] : date('Y-m-d');

                                            // Loop through each employee
                                            while ($employee = $employees->fetch()) {
                                                // Check if attendance for this employee has already been recorded for the selected date
                                                $attendance = $conn->query("SELECT status FROM attendance WHERE employee_id = '{$employee['id']}' AND `date` = '{$attendanceDate}'")->fetch();

                                                // Set the appropriate radio button as checked based on the previous attendance
                                                $presentChecked = ($attendance && $attendance['status'] == 'Present') ? 'checked' : '';
                                                $absentChecked = ($attendance && $attendance['status'] == 'Absent') ? 'checked' : '';
                                                $leaveChecked = ($attendance && $attendance['status'] == 'Leave') ? 'checked' : '';

                                                // Output the row with pre-checked radio buttons if attendance exists
                                                echo "<tr>
                                                    <td>{$sn}</td>
                                                    <td>{$employee['employeeName']}</td>
                                                    <td><input type='radio' name='attendance[{$employee['id']}]' value='Present' {$presentChecked}></td>
                                                    <td><input type='radio' name='attendance[{$employee['id']}]' value='Absent' {$absentChecked}></td>
                                                    <td><input type='radio' name='attendance[{$employee['id']}]' value='Leave' {$leaveChecked}></td>
                                                </tr>";
                                                $sn++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <div class="form-group col-md-12">
                                        <button class="btn btn-primary" type="submit" name="submit"
                                            onclick="validateattendance()">Save Attendance</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div><!--end card-->
            </div><!--end col-->
        </div><!--end row-->
    </div> <!-- Page content Wrapper -->

    </di v> <!-- content -->
    <?php include('include/footer.php'); ?>


    <script>
        function validateattendance() {
            // Custom method to check if one of the radio options (Present or Absent) is selected
            $.validator.addMethod("requireRadio", function (value, element) {
                return $("input[name='attendanceStatus']:checked").length > 0;
            }, "Please select either Present or Absent");

            $('#mark_attendance').validate({
                rules: {
                    attendanceStatus: {
                        requireRadio: true
                    },
                    attendanceDate: {
                        required: true,
                        date: true
                    }
                },
                messages: {
                    attendanceStatus: {
                        requireRadio: "Please select either Present or Absent or Leave"
                    },
                    attendanceDate: {
                        required: "Please select a date for attendance",
                        date: "Please enter a valid date"
                    }
                }
            });
        }

    </script>