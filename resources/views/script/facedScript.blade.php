<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

<script>
    function formatNumber(input) {
      const cursorPosition = input.selectionStart;

      let value = input.value.replace(/[^0-9.]/g, '');

      value = parseFloat(value).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });

      input.value = value;

      input.setSelectionRange(cursorPosition, cursorPosition);
    }
</script>   
<script>
    function addFamilyMember() {
        var clonedFormGroup = $('#fam-me-row').clone();

        clonedFormGroup.removeAttr('id');

        $('#fam-me-row').parent().append(clonedFormGroup);
    }
</script>

<script>
    function genSerial(val, newCount) {
        var serialNumber = '746140-' + val + '-' + newCount;
        $('#serial').val(serialNumber);
    }
</script>

<script>
    $(document).ready(function () {  
        $('#d_birth').on('change', function () {
            calculateAge();
        });
    });

    function calculateAge() {
        var dob = new Date($('#d_birth').val());
        var today = new Date();

        var age = today.getFullYear() - dob.getFullYear();

        if (today.getMonth() < dob.getMonth() || (today.getMonth() === dob.getMonth() && today.getDate() < dob.getDate())) {
            age--;
        }

        $('#age').val(age);

        // Disable dates that result in an age less than 60

    }
</script>

<script>
    var dafacDeleteRoute = "{{ route('dafacDelete', ':id') }}";
</script> 

<script>
    $(document).on('click', '.dafac-delete', function(e) {
        var id = $(this).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        });
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url: dafacDeleteRoute.replace(':id', id),
                    success: function(response) {
                        Swal.fire({
                            title: 'Deleted!',
                            text: 'Successfully Deleted!',
                            type: 'success',
                            icon: 'warning',
                            showConfirmButton: false,
                            timer: 1000
                        }).then(function () { window.location.reload(); });
                    }
                });
            }
        })
    });
</script>

<script>
    var assDelete = "{{ route('assDelete', ':id') }}";
</script> 

<script>
    $(document).on('click', '.assistance-delete', function(e) {
        var id = $(this).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        });
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url: assDelete.replace(':id', id),
                    success: function(response) {
                        Swal.fire({
                            title: 'Deleted!',
                            text: 'Successfully Deleted!',
                            type: 'success',
                            icon: 'warning',
                            showConfirmButton: false,
                            timer: 1000
                        }).then(function () { window.location.reload(); });
                    }
                });
            }
        })
    });
</script>
