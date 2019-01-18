var CloudIntegration = {

	share: function(pGuid, pName, pPath) {

		var newShare = false;
		
		if ($('#cloud_new').is(":checked")){

			newShare = true;
		}

		var descrp = $("#cloud_descrp").val();
		var commentsOn = $("#cloud_comments_on").val();
		var strTags = $("#cloud_tags").val();
		var passwd = '';
		var accessID = $("#cloud_access_id").val();

		if(!$("#cloud_passwd").prop("disabled")){ // if passwd enable

			passwd = $("#cloud_passwd").val();
		}

		var moduleSpinner = 'elgg/spinner';
		require([moduleSpinner], function(spinner){

			elgg.action('cloudintegration/share', {
				beforeSend: spinner.start,
				complete: spinner.stop,
				data: {
					guid: pGuid,
					access_id: accessID,
					title: pName,
					description: descrp,
					path: pPath,
					password: passwd,
					newshare: newShare ? 1 : 0,
					comments_on: commentsOn,
					tags: strTags,
				},
				success: function (wrapper) {

					if (wrapper.output) {
						/*require(['elgg/lightbox'], function (lightbox) {
           						return lightbox.close.apply(this, arguments);
         					});*/
						location.reload();
					} else {
						// the system prevented the action from running
					}
				}
			});
		});

	},

	unshare: function(pGUID, pID) {

		var moduleSpinner = 'elgg/spinner';
		require([moduleSpinner], function(spinner){

			elgg.action('cloudintegration/unshare', {
				beforeSend: spinner.start,
				complete: spinner.stop,
				data: {
					guid: pGUID,
					id: pID,
				},
				success: function (wrapper) {
					if (wrapper.output) {
						/*require(['elgg/lightbox'], function (lightbox) {
           						return lightbox.close.apply(this, arguments);
         					});*/
						location.reload();
					} else {
						// the system prevented the action from running
					}
				}
			});
		});

	},

	visibility: function(pGUID, pVisible) {

		var moduleSpinner = 'elgg/spinner';
		require([moduleSpinner], function(spinner){

			elgg.action('cloudintegration/visibility', {
				beforeSend: spinner.start,
				complete: spinner.stop,
				data: {
					guid: pGUID,
					visible: pVisible.toString(),
				},
				success: function (wrapper) {
					if (wrapper.output.status == 'ok') {

						if(pVisible){

							$("#civisible" + pGUID).css("display", "block");
							$("#ciinvisible" + pGUID).css("display", "none");
						}else{

							$("#civisible" + pGUID).css("display", "none");
							$("#ciinvisible" + pGUID).css("display", "block");
						}
					} else {
						// the system prevented the action from running
					}
				}
			});
		});

	},

	optformpass: function() {

		if ($('#cloud_new').is(":checked")){

			$( "#cloud_passwd").prop("disabled",false);
		}else{

			$( "#cloud_passwd" ).prop("disabled",true);
			$( "#cloud_passwd" ).val("");
		}

	}

};

