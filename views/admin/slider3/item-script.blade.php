<script>
	$(function (){
		FormHelper.reset();

		$(document).on('click', '#js_slider_item__edit .nav-tabs li a', function () {
			FormHelper.reset();
		})

		$(document).on('click','.jsCaptionList li label', function(e) {

			let id = $(this).attr('data-key');

			let data = {
				'action'        : 'SliderNoTitleAjax::itemCaptionLoad',
				'captionKey'	: id,
				'id'	        : $(this).attr('data-id'),
			};

			request.post(ajax, data).then(function(response) {
				if( response.status === 'success') {
					$('#jsCaptionConfigContent').html(response.data);
					FormHelper.reset();
				}
			});
		});
	});
</script>