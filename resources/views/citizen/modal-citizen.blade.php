
<div class="modal fade" id="modal-citizen">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">
                    <i class="fas fa-user-plus"></i> Add New
                </h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body">
                <form action="{{ route('citizenCreate') }}" class="form-horizontal" id="addCitizen" method="POST">
                    @csrf

                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-12">
                                <label for="exampleInputName">Last Name:</label>
                                <input type="text" name="lname" placeholder="Enter Last Name" class="form-control text-capitalize">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-12">
                                <label for="exampleInputName">First Name:</label>
                                <input type="text" name="fname" placeholder="Enter First Name" class="form-control text-capitalize">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-12">
                                <label for="exampleInputName">Middle Name:</label>
                                <input type="text" name="mname" placeholder="Enter Middle Name" class="form-control text-capitalize">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-12">
                                <label for="exampleInputName">Extension (Jr,Sr)</label>
                                <input type="text" name="ext"  placeholder="Enter Ext." class="form-control text-capitalize">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-12">
                                <label for="exampleInputName">Gender</label>
                                <select type="text" name="gender" class="form-control mt2" required>
                                    <option>Male</option>
                                    <option>Female</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-12">
                                <label for="exampleInputName">Birthdate</label>
                                <input type="date" name="bday" id="bday" style="width: 90%;" class="form-control mt2 float-left">
                                <input type="text" name="age" id="age" class="form-control text-center mt2 float-right" style="width: 10%;" readonly>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-12">
                                <button type="submit" name="btn-submit" class="btn btn-success" id="submit-btn">
                                    <i class="fas fa-save"></i> Save
                                </button>
                            </div>
                        </div>
                    </div>   
                </form>
            </div>
            
            <div class="modal-footer justify-content-between">
                <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('bday').addEventListener('change', function() {
        const birthDate = new Date(this.value);
        const age = calculateAge(birthDate);
        document.getElementById('age').value = age;

        const ageWarning = document.getElementById('age-warning');
        const submitBtn = document.getElementById('submit-btn');

        if (age < 60) {
            ageWarning.style.display = 'block';
            submitBtn.disabled = true;
        } else {
            ageWarning.style.display = 'none';
            submitBtn.disabled = false;
        }
    });
    
    document.getElementById('addCitizen').addEventListener('submit', function(event) {
        const age = document.getElementById('age').value;
        if (age < 60) {
            event.preventDefault();
            toastr.options = {
                "closeButton":true,
                "progressBar":true,
                'positionClass': 'toast-bottom-right'
            }
            toastr.error("Age must be 60 or above")
        }
    });

    function calculateAge(birthDate) {
        const today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        const monthDiff = today.getMonth() - birthDate.getMonth();
        const dayDiff = today.getDate() - birthDate.getDate();

        if (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) {
            age--;
        }

        return age;
    }
</script>