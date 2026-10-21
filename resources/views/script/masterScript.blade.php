<script>
    @if(Session::has('error'))
        toastr.options = {
            "closeButton":true,
            "progressBar":true,
            'positionClass': 'toast-bottom-right'
        }
        toastr.error("{{ session('error') }}")
    @endif
    @if($errors->any())
        @foreach($errors->all() as $error)
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                'positionClass': 'toast-bottom-center'
            }
            toastr.error("{{ $error }}");
        @endforeach
    @endif
</script>

<script>
    @if(Session::has('success'))
        toastr.options = {
            "closeButton":true,
            "progressBar":true,
            'positionClass': 'toast-bottom-right'
        }
        toastr.success("{{ session('success') }}")
    @endif
</script>

<script>
    $(function () {
        const recordTable = $("#example1");
        if (recordTable.length) {
            const isDafacTable = recordTable.hasClass('dafac-table');
            recordTable.DataTable({
                "responsive": false,
                "lengthChange": true,
                "autoWidth": !isDafacTable,
                "language": isDafacTable ? {
                    "emptyTable": '<div class="dafac-empty"><i class="fas fa-folder-open" aria-hidden="true"></i><strong>No family records yet</strong><span>Add a family record to get started.</span></div>',
                    "zeroRecords": 'No family records match your search.'
                } : {}
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        }


        $("#example3").DataTable({
            "responsive": true,
            "lengthChange": false, 
            "autoWidth": false,
            "buttons": ["copy", "excel"]
            // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]

        }).buttons().container().appendTo('#example3_wrapper .col-md-6:eq(0)');
        $('select').not('[data-native-select]')
            .filter(function () { return !$(this).hasClass('select2-hidden-accessible'); })
            .each(function () {
                const modal = $(this).closest('.modal');
                const options = { theme: 'bootstrap4', width: $(this).closest('.dataTables_length').length ? '76px' : '100%', minimumResultsForSearch: 0 };
                if (modal.length) options.dropdownParent = modal;
                $(this).select2(options);
            });
    });
</script>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    
        $('#region').change(function() {
            var regionId = $(this).val();
     
            if (regionId) {
                
                $.ajax({
                    url: "{{ route('getProvinces', ['regionId' => ':regionId']) }}".replace(':regionId', regionId),
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('#province').empty();
                        $('#province').append('<option value="">Select Province</option>');
                        $.each(data, function(key, value) {
                            let citizenId = "{{ isset($citizenid) ? $citizenid : '' }}";
                            
                            $('#province').append(
                                '<option value="' + value.province_id + 
                                '" data-column-id="' + citizenId + 
                                '" data-column-name="add_prov">' + 
                                value.name + '</option>'
                            );
                        });
                        $('#province').prop('disabled', false);
                    },
                    error: function() {
                        $('#province').empty();
                        $('#province').append('<option value="">Select Province</option>');
                        $('#province').prop('disabled', true);
                    }
                });
            } else {
                $('#province').empty();
                $('#province').append('<option value="">Select Province</option>');
                $('#province').prop('disabled', true);
            }
        });
    
        // AJAX request to get cities based on selected province
        $('#province').change(function() {
            var provinceId = $(this).val();
            if (provinceId) {
                $.ajax({
                    url: "{{ route('getCities', ['provinceId' => ':provinceId']) }}".replace(':provinceId', provinceId),
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('#city').empty();
                        $('#city').append('<option value="">Select City</option>');
                        $.each(data, function(key, value) {
                            let citizenId = "{{ isset($citizenid) ? $citizenid : '' }}";
                            $('#city').append(
                                '<option value="' + value.city_id + 
                                '" data-column-id="' + citizenId + 
                                '" data-column-name="add_city">' + 
                                value.name + '</option>'
                            );
                        });
                        $('#city').prop('disabled', false);
                    },
                    error: function() {
                        $('#city').empty();
                        $('#city').append('<option value="">Select City</option>');
                        $('#city').prop('disabled', true);
                    }
                });
            } else {
                $('#city').empty();
                $('#city').append('<option value="">Select City</option>');
                $('#city').prop('disabled', true);
            }
        });
    
        // AJAX request to get barangays based on selected city
        $('#city').change(function() {
            var cityId = $(this).val();
            if (cityId) {
                $.ajax({
                    url: "{{ route('getBarangays', ['cityId' => ':cityId']) }}".replace(':cityId', cityId),
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('#barangay').empty();
                        $('#barangay').append('<option value="">Select Barangay</option>');
                        $.each(data, function(key, value) {
                            let citizenId = "{{ isset($citizenid) ? $citizenid : '' }}";
                            $('#barangay').append(
                                '<option value="' + value.id + 
                                '" data-column-id="' + citizenId + 
                                '" data-column-name="add_brgy">' + 
                                value.name + '</option>'
                            );
                        });
                        $('#barangay').prop('disabled', false);
                    },
                    error: function() {
                        $('#barangay').empty();
                        $('#barangay').append('<option value="">Select Barangay</option>');
                        $('#barangay').prop('disabled', true);
                    }
                });
            } else {
                $('#barangay').empty();
                $('#barangay').append('<option value="">Select Barangay</option>');
                $('#barangay').prop('disabled', true);
            }
        });
    });
</script>
