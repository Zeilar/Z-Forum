{{-- Fill Summernote editor text box --}}
<script>
	$(document).ready(() => {
		$('#form-content').summernote('code', '{!!$value!!}');
	});
</script>