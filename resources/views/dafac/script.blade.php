    
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
