<!-- Bootstrap JS -->
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<!--plugins-->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
<script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/plugins/chartjs/js/Chart.min.js') }}"></script>
<script src="{{ asset('assets/plugins/chartjs/js/Chart.extension.js') }}"></script>
<script src="{{ asset('assets/js/index.js') }}"></script>
<!--app JS-->
<script src="{{ asset('assets/js/app.js') }}"></script>
<script src="https://developercodez.com/developerCorner/parsley/parsley.min.js"></script>

<script>
    $(document).ready(function() {
        $("#show_hide_password a").on('click', function(event) {
            event.preventDefault();
            if ($('#show_hide_password input').attr("type") == "text") {
                $('#show_hide_password input').attr('type', 'password');
                $('#show_hide_password i').addClass("bx-hide");
                $('#show_hide_password i').removeClass("bx-show");
            } else if ($('#show_hide_password input').attr("type") == "password") {
                $('#show_hide_password input').attr('type', 'text');
                $('#show_hide_password i').removeClass("bx-hide");
                $('#show_hide_password i').addClass("bx-show");
            }
        });
    });
</script>



<script>
    $(document).ready(function() {
        $('#formSubmit').on('submit', function(e) {
            if ($(this).parsely().validate()) {
                e.preventDefault();
                var formData = new FormData(this);
                var html = `<button class="btn btn-primary" type="button" disabled="">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                <span class="visually-hidden">Loading...</span></button>`;
                var httml1 = `<button type="submit" id="submitButton" class="btn btn-primary px-4">Save Changes</button>`;
                $('#submitButton').html(html);
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(result) {
                        if(result.status == 'success'){
                            showAlert(result.status,result.message);
                            $('#submitButton').html(html1);
                            if(result.data.reload != undefined){
                                window.location.href = window.location.href;
                            }
                        }else{
                            showAlert(result.status,result.message);
                            $('#submitButton').html(httml1);
                        }
                    },
                    error:function(result)
                    {
                        showAlert(result.responseJSON.status,result.responseJSON.message);
                        $('#submitButton').html(httml1);
                        
                    }
                    
                });
                $('#submitButton').html(html1);

            }
        });
    });
	function deleteData(id, table) {
            if (confirm("Are you sure you want to delete this item?")) {
                fetch(`/deletData/${id}/${table}`, {
                        method: 'DELETE', 
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === true) {
                            alert(data.message);
                            location.reload(); 
                        } else {
                            alert(data.message); 
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert("Something went wrong. Please try again.");
                    });
            }
        }
</script>

<script>
    $(document).ready(function() {
        $('#example').DataTable();
      } );
</script>
<script>
    $(document).ready(function() {
        var table = $('#example2').DataTable( {
            lengthChange: false,
            buttons: [ 'copy', 'excel', 'pdf', 'print']
        } );
     
        table.buttons().container()
            .appendTo( '#example2_wrapper .col-md-6:eq(0)' );
    } );
</script>

{{-- New function add --}}
{{-- <script>
	$(document).ready(() => {
		$("#photo").change(function() {
			const file = this.files[0];
			if (file) {
				let reader = new FileReader();
				reader.onload = function(event) {
					$("#imgPreview")
						.attr("src", event.target.result);
				};
				reader.readAsDataURL(file);
			}
		});
	});
</script>
<script>
	function showAlert(status, message) {
		SnackBar({
			status: status,
			message: message,
			position: "br"
		});
	}
</script> --}}