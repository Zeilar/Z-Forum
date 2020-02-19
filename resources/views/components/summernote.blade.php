{{-- Summernote settings --}}
<script>
	$(document).ready(() => {
		$('#form-content').summernote(
			{
				'code': '{!! $value ?? null !!}',
				'placeholder': '{!! $placeholder ?? null !!}',
				'height': '{!! $height ?? null !!}',
			}
		);
	});
</script>