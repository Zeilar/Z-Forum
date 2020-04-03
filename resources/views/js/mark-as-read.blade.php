<script>
	async function mark_as_read() {
		let response = await fetch(`{{ route("mark_as_read", [$collection, $id]) }}`, {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
				'X-CSRF-Token': '{{ csrf_token() }}',
			},
		})
		.then(response => {
			$('.folder').removeClass('fa-folder').addClass('fa-folder-open');
			$('.table-row').addClass('read');
		})
		.catch(error => {
			console.log(error);
		});
	}
</script>