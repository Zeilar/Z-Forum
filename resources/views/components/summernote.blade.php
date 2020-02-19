{{-- Summernote settings --}}
<script>
	$(document).ready(() => {
		$('#form-content').summernote(
			{
				'placeholder': '{!! $placeholder ?? null !!}',
				'height'	 : '{!! $height ?? 200 !!}',
				'code'		 : '{!! $value ?? null !!}',
			}
		);
	});
</script>