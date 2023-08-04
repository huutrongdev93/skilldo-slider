<script>
	$(function (){
		formBuilderReset();

		$(document).on('click', '#js_slider_item__edit .nav-tabs li a', function () {
			formBuilderReset();
		})

		$(document).on('click','.jsCaptionList li label', function(e) {

			let id = $(this).attr('data-key');

			let data = {
				'action'        : 'SliderNoTitleAjax::itemCaptionLoad',
				'captionKey'	: id,
				'id'	        : $(this).attr('data-id'),
			};

			$.post(ajax, data, function(response) {}, 'json').done(function(response) {
				if( response.status === 'success') {
					$('#jsCaptionConfigContent').html(response.data);
					console.log('a')
					formBuilderReset();
				}
			});
		});
	});
</script>