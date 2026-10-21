@if(request()->is('senior'))
<script>
    var citizenDeleteRoute = "{{ route('citizenDelete', ':id') }}";
</script> 

<script>
    function printSticker(idcard_id) {
        $.ajax({
            url: "{{ route('citizenPrntSticker', ':id') }}".replace(':id', idcard_id),
            method: 'GET',
            success: function(response) {
                
                $('#modal-prntIDcard .modal-body').html(response);
                
                $('#modal-prntIDcard').modal('show');  

                $(".downloadStickerButton").each(function() {
                    $(this).val(idcard_id);
                });
            }
        });
    }
</script>

<script>
    $(document).on('click', '.citizen-delete', function(e) {
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
                    url: citizenDeleteRoute.replace(':id', id),
                    success: function(response) {
                        $("#tr-" + id).delay(1000).fadeOut();
                        Swal.fire({
                            title: 'Deleted!',
                            text: 'Successfully Deleted!',
                            type: 'success',
                            icon: 'warning',
                            showConfirmButton: false,
                            timer: 1000
                        })
                    }
                });
            }
        })
    });
</script>
<script>
    $(document).ready(function() {
        // Set up the CSRF token for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });

    function updateStatus(citizenId, newStatus) {
        var url = '{{ route('updateCitizenStatus', ':id') }}'.replace(':id', citizenId);

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                status: newStatus
            },
            success: function(response) {
                if (response.success) {
                    // Determine the appropriate badge class based on the new status
                    var badgeClass = 'badge-warning'; // Default class

                    if (newStatus === 'Active / Pensioner') {
                        badgeClass = 'badge-success';
                    } else if (newStatus === 'Deceased') {
                        badgeClass = 'badge-danger';
                    } else if (newStatus === 'Waiting') {
                        badgeClass = 'badge-warning';
                    }

                    // Update the badge text and class with the new status
                    var badgeElement = $('#statusDropdown-' + citizenId);
                    badgeElement.text(newStatus);
                    badgeElement.removeClass('badge-success badge-danger badge-warning').addClass(badgeClass);

                    //alert('Status updated successfully!');
                } else {
                    //alert('Failed to update status.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert('An error occurred while updating the status.');
            }
        });
    }
</script>
@endif
@if(request()->is('senior/*'))
<script>
    $('input[data-update], select[data-update]').on('change', function() {
        var data = $(this).data('update');
        var value = $(this).val();
        var model = $(this).data('model');
        var array = $(this).data('array');
        var age = "";

        if(data == "bday"){
            var selectedDate = value;
            var birthDate = new Date(selectedDate);
            var currentDate = new Date();
            var age = currentDate.getFullYear() - birthDate.getFullYear();

            if (
                currentDate.getMonth() < birthDate.getMonth() ||
                (currentDate.getMonth() === birthDate.getMonth() && currentDate.getDate() < birthDate.getDate())
            ) {
                age--;
            }

            document.getElementById("age").value = age;

        }

        var cid = $(this).data('cid');

        $.ajax({
            url: '{{ route('MoreInfoUpdate') }}', 
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                data: data,
                value: value,
                model: model,
                array: array,
                cid: cid,
                age: age,
            },
            success: function(response) {
                if (response.success) {
                    console.log(response.success);
                } else {
                    console.log(response.error);
                }
            },
            error: function(xhr) {
                console.log('An error occurred: ' + xhr.status + ' ' + xhr.statusText);
            }
        });
    });
    
</script>
<script>
    const checkboxes = document.querySelectorAll('input[type="checkbox"][id="med_concernchk"]');

    // Add an event listener to each checkbox
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            // If this checkbox is checked, uncheck the others
            if (this.checked) {
                checkboxes.forEach(otherCheckbox => {
                    if (otherCheckbox !== this) {
                        otherCheckbox.checked = false;
                    }
                });
            }
        });
    });
</script>

<script>
    const checkboxes1 = document.querySelectorAll('input[type="checkbox"][id="camp_travel"]');

    // Add an event listener to each checkbox
    checkboxes1.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            // If this checkbox is checked, uncheck the others
            if (this.checked) {
                checkboxes1.forEach(otherCheckbox => {
                    if (otherCheckbox !== this) {
                        otherCheckbox.checked = false;
                    }
                });
            }
        });
    });
</script>

<script>
const checkboxes2 = document.querySelectorAll('input[type="checkbox"][id="med_sched"]');

// Add an event listener to each checkbox
checkboxes2.forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        // If this checkbox is checked, uncheck the others
        if (this.checked) {
            checkboxes2.forEach(otherCheckbox => {
                if (otherCheckbox !== this) {
                    otherCheckbox.checked = false;
                }
            });
        }
    });
});
</script>


<script>
const checkboxes3 = document.querySelectorAll('input[type="checkbox"][id="med_schedyes"]');

// Add an event listener to each checkbox
checkboxes3.forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        // If this checkbox is checked, uncheck the others
        if (this.checked) {
            checkboxes3.forEach(otherCheckbox => {
                if (otherCheckbox !== this) {
                    otherCheckbox.checked = false;
                }
            });
        }
    });
});
</script>
    
<script>
    var minAllowedDate = new Date();
    minAllowedDate.setFullYear(minAllowedDate.getFullYear() - 60);
    var formattedMinAllowedDate = minAllowedDate.toISOString().split('T')[0];
    $('#bday').attr('max', formattedMinAllowedDate);
</script>

<script>
    $(document).ready(function() {
        // Set up CSRF token for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    
        // // AJAX request to get provinces based on selected region
        // $('#region').change(function() {
        //     var regionId = $(this).val();
     
        //     if (regionId) {
                
        //         $.ajax({
        //             url: "{{ route('getProvinces', ['regionId' => ':regionId']) }}".replace(':regionId', regionId),
        //             type: "GET",
        //             dataType: "json",
        //             success: function(data) {
        //                 $('#province').empty();
        //                 $('#province').append('<option value="">Select Province</option>');
        //                 $.each(data, function(key, value) {
        //                     let citizenId = "{{ $citizen->id }}";
                            
        //                     $('#province').append(
        //                         '<option value="' + value.province_id + 
        //                         '" data-column-id="' + citizenId + 
        //                         '" data-column-name="add_prov">' + 
        //                         value.name + '</option>'
        //                     );
        //                 });
        //                 $('#province').prop('disabled', false);
        //             },
        //             error: function() {
        //                 $('#province').empty();
        //                 $('#province').append('<option value="">Select Province</option>');
        //                 $('#province').prop('disabled', true);
        //             }
        //         });
        //     } else {
        //         $('#province').empty();
        //         $('#province').append('<option value="">Select Province</option>');
        //         $('#province').prop('disabled', true);
        //     }
        // });
    
        // // AJAX request to get cities based on selected province
        // $('#province').change(function() {
        //     var provinceId = $(this).val();
        //     if (provinceId) {
        //         $.ajax({
        //             url: "{{ route('getCities', ['provinceId' => ':provinceId']) }}".replace(':provinceId', provinceId),
        //             type: "GET",
        //             dataType: "json",
        //             success: function(data) {
        //                 $('#city').empty();
        //                 $('#city').append('<option value="">Select City</option>');
        //                 $.each(data, function(key, value) {
        //                     let citizenId = "{{ $citizen->id }}";
        //                     $('#city').append(
        //                         '<option value="' + value.city_id + 
        //                         '" data-column-id="' + citizenId + 
        //                         '" data-column-name="add_city">' + 
        //                         value.name + '</option>'
        //                     );
        //                 });
        //                 $('#city').prop('disabled', false);
        //             },
        //             error: function() {
        //                 $('#city').empty();
        //                 $('#city').append('<option value="">Select City</option>');
        //                 $('#city').prop('disabled', true);
        //             }
        //         });
        //     } else {
        //         $('#city').empty();
        //         $('#city').append('<option value="">Select City</option>');
        //         $('#city').prop('disabled', true);
        //     }
        // });
    
        // // AJAX request to get barangays based on selected city
        // $('#city').change(function() {
        //     var cityId = $(this).val();
        //     if (cityId) {
        //         $.ajax({
        //             url: "{{ route('getBarangays', ['cityId' => ':cityId']) }}".replace(':cityId', cityId),
        //             type: "GET",
        //             dataType: "json",
        //             success: function(data) {
        //                 $('#barangay').empty();
        //                 $('#barangay').append('<option value="">Select Barangay</option>');
        //                 $.each(data, function(key, value) {
        //                     let citizenId = "{{ $citizen->id }}";
        //                     $('#barangay').append(
        //                         '<option value="' + value.id + 
        //                         '" data-column-id="' + citizenId + 
        //                         '" data-column-name="add_brgy">' + 
        //                         value.name + '</option>'
        //                     );
        //                 });
        //                 $('#barangay').prop('disabled', false);
        //             },
        //             error: function() {
        //                 $('#barangay').empty();
        //                 $('#barangay').append('<option value="">Select Barangay</option>');
        //                 $('#barangay').prop('disabled', true);
        //             }
        //         });
        //     } else {
        //         $('#barangay').empty();
        //         $('#barangay').append('<option value="">Select Barangay</option>');
        //         $('#barangay').prop('disabled', true);
        //     }
        // });
    
    
        // AJAX request to get provinces based on selected region
        $('#region1').change(function() {
            var regionId = $(this).val();
            if (regionId) {
                $.ajax({
                    url: "{{ route('getProvinces', ['regionId' => ':regionId']) }}".replace(':regionId', regionId),
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('#province1').empty();
                        $('#province1').append('<option value="">Select Province</option>');
                        $.each(data, function(key, value) {
                            let citizenId = "{{ $citizen->id }}";
                            $('#province1').append(
                                '<option value="' + value.province_id + 
                                '" data-column-id="' + citizenId + 
                                '" data-column-name="padd_prov">' + 
                                value.name + '</option>'
                            );
                        });
                        $('#province1').prop('disabled', false);
                    },
                    error: function() {
                        $('#province1').empty();
                        $('#province1').append('<option value="">Select Province</option>');
                        $('#province1').prop('disabled', true);
                    }
                });
            } else {
                $('#province1').empty();
                $('#province1').append('<option value="">Select Province</option>');
                $('#province1').prop('disabled', true);
            }
        });
    
        // AJAX request to get cities based on selected province
        $('#province1').change(function() {
            var provinceId = $(this).val();
            if (provinceId) {
                $.ajax({
                    url: "{{ route('getCities', ['provinceId' => ':provinceId']) }}".replace(':provinceId', provinceId),
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('#city1').empty();
                        $('#city1').append('<option value="">Select City</option>');
                        $.each(data, function(key, value) {
                            let citizenId = "{{ $citizen->id }}";
                            $('#city1').append(
                                '<option value="' + value.city_id + 
                                '" data-column-id="' + citizenId + 
                                '" data-column-name="padd_city">' + 
                                value.name + '</option>'
                            );
                        });
                        $('#city1').prop('disabled', false);
                    },
                    error: function() {
                        $('#city1').empty();
                        $('#city1').append('<option value="">Select City</option>');
                        $('#city1').prop('disabled', true);
                    }
                });
            } else {
                $('#city1').empty();
                $('#city1').append('<option value="">Select City</option>');
                $('#city1').prop('disabled', true);
            }
        });
    
        // AJAX request to get barangays based on selected city
        $('#city1').change(function() {
            var cityId = $(this).val();
            if (cityId) {
                $.ajax({
                    url: "{{ route('getBarangays', ['cityId' => ':cityId']) }}".replace(':cityId', cityId),
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('#barangay1').empty();
                        $('#barangay1').append('<option value="">Select Barangay</option>');
                        $.each(data, function(key, value) {
                            let citizenId = "{{ $citizen->id }}";
                            $('#barangay1').append(
                                '<option value="' + value.id + 
                                '" data-column-id="' + citizenId + 
                                '" data-column-name="padd_brgy">' + 
                                value.name + '</option>'
                            );
                        });
                        $('#barangay1').prop('disabled', false);
                    },
                    error: function() {
                        $('#barangay1').empty();
                        $('#barangay1').append('<option value="">Select Barangay</option>');
                        $('#barangay1').prop('disabled', true);
                    }
                });
            } else {
                $('#barangay1').empty();
                $('#barangay1').append('<option value="">Select Barangay</option>');
                $('#barangay1').prop('disabled', true);
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('.update-field').on('change', function() {
            var elementType = $(this).prop('tagName').toLowerCase();
            columnid = $(this).find('option:selected').data('column-id');
            columnname = $(this).find('option:selected').data('column-name');
        

            var value = $(this).val();

            $.ajax({
                url: '{{ route("addressUpdate") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: columnid,
                    column: columnname,
                    value: value
                },
                success: function(response) {
                    
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        console.error('Validation errors:', errors);
                    } else {
                        console.error('Error:', error);
                    }
                }
            });
        });
    });
</script>
<script>
    document.getElementById('fileInput').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').src = e.target.result;

                const formData = new FormData();
                formData.append('image', file);
                formData.append('oldImage', '{{ $citizen->profile }}'); 

                fetch('{{ route('update-profile-image', $citizen->id) }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                }).then(response => response.json())
                  .then(data => {
                      if (data.success) {
                          console.log('Image updated successfully');
                      } else {
                          console.error('Failed to update image');
                      }
                  }).catch(error => {
                      console.error('Error:', error);
                  });
            };
            reader.readAsDataURL(file);
        }
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const uploadUrl = `{{ route('updateCitizenFiles', ['id' => ':id']) }}`;
    const deleteUrl = `{{ route('deleteFile', ['id' => ':id', 'fileName' => ':fileName']) }}`;

    document.getElementById('fileLabel').addEventListener('click', function() {
        document.getElementById('fileInputUpload').click();
    });

    document.getElementById('fileInputUpload').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const formData = new FormData();
            formData.append('file', file);

            const url = uploadUrl.replace(':id', {{ $citizen->id }});

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const newRow = document.createElement('tr');
                    newRow.classList.add('fade-in');
                    newRow.setAttribute('data-file', data.file.name);
                    newRow.innerHTML = `
                        <td><a href="${data.file.url}" target="_blank">${data.file.name}</a></td>
                        <td width="50">
                            <button class="btn btn-outline-danger btn-sm" onclick="deleteFile('${data.file.name}')">
                                <i class="fas fa-times"></i>
                            </button>
                        </td>`;
                    document.querySelector('table tbody').appendChild(newRow);

                    setTimeout(() => {
                        newRow.classList.add('visible');
                    }, 10);
                } else {
                    alert('Failed to upload file: ' + (data.message || 'Unknown error.'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while uploading the file.');
            });
        }
    });

    window.deleteFile = function(fileName) {
        const citizenId = {{ $citizen->id }};
        const url = deleteUrl.replace(':id', citizenId).replace(':fileName', fileName);

        if (confirm('Are you sure you want to delete this file?')) {
            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const row = document.querySelector(`tr[data-file="${fileName}"]`);
                    if (row) {
                        row.classList.add('fade-out');
                        setTimeout(() => {
                            row.remove();
                        }, 500); 
                    }
                } else {
                    alert('Failed to delete file: ' + (data.message || 'Unknown error.'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while deleting the file.');
            });
        }
    };
});

</script>
@endif