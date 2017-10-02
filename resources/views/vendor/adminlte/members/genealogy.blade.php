@extends('adminlte::layouts.member')

@section('contentheader_title')
	{{ trans('adminlte_lang::member.genealogy') }}
@endsection

@section('main-content')
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<div class="col-sm-3 no-padding">
						<div class="input-group input-group-sm">
							<input type="text" class="form-control" id="search-input" placeholder="{{ trans('adminlte_lang::member.refferals_username') }}">
							<span class="input-group-btn">
								<button type="button" id="search-button" class="btn btn-primary btn-flat" ><i class="fa fa-search"></i> {{ trans('adminlte_lang::member.btn_search') }}</button>
							</span>
						</div>
					</div>
				</div>
				<div class="box-body" style="padding-top:0;">
					<div id="genealogy-container" style="min-width: 150px; min-height: 100px;"></div>
				</div>
			</div>
		</div>
	</div>
	<link rel="stylesheet" href="{{ asset('/css/jstree.css') }}" />
	<script src="{{ asset('/js/jstree.js') }}"></script>
	<script src="{{ asset('/js/jstreetable.js') }}"></script>
	<script>
		$(function () {
			$("#genealogy-container").jstree({
				plugins: ["table", "search", "json_data", "addFunctions"],
				core: {
					data: function(node, cb) {
						$.ajax({
							url: node.id=="#"?"?action=getUser":"?action=getChildren",
							data: {
								id: node.id,
								username: $('#search-input').val(),
							},
							timeout : 15000
						}).done(function(data) {
							if (data.err) {
								swal({
									title: "There's something wrong",
									text: ErrorCodes[data.err],
									type: "error"
								});
							} else {
								if (data instanceof Array) {
									var children = [];
									for (var i = 0; i < data.length; i++) {
										var user = data[i];
										children.push({
											//text: user.id +' '+ user.u + ' (' + user.dmc + ')',
											text: user.uid +' '+ user.u,
											data: {
												username: user.id +' '+ user.u,
                                                packageId: buildPackHtml(user.packageId),
                                                totalMembers: user.totalMembers,
                                                leg: user.leg,
                                                loyaltyId: buildLoyaltyHtml(user.loyaltyId),
												level: user.l,
                                                generation: user.generation,
											},
											id: user.id,
											children: user.dmc?true:false,
											icon: "/img/jstree/user.png",
											state: {opened: parseInt(user.totalMembers) > 0 ? false : true}
										});
									}
									cb(children);
								} else {
									var user = data;
									cb([{
										text: user.uid +' '+ user.u,
										data: {
											username: user.id +' '+ user.u,
                                            packageId: buildPackHtml(user.packageId),
                                            totalMembers: user.totalMembers,
                                            leg: user.leg,
                                            loyaltyId: buildLoyaltyHtml(user.loyaltyId),
											level: user.l,
                                            generation: user.generation,
										},
										id: user.id,
										children: user.dmc?true:false,
										icon: "/img/jstree/user.png",
                                        state: {opened: parseInt(user.totalMembers) > 0 ? false : true}
									}]);
								}
							}
						});
					},
					load_open : true
				},
				// configure tree table
				table: {
					columns: [
						{width: '50%', header: "ID/Username"},
						{width: '5%', value: "totalMembers", header: "Total member"},
						{width: '5%', value: "packageId", header: "Active Package"},
						{width: '5%', value: "leg", header: "Left/Right"},
						{width: '5%', value: "loyaltyId", header: "Loyalty"},
						{width: '5%', value: "generation", header: "Qualify"},
					],
					width: "100%",
					fixedHeader: false,
					resizable: true,
				}
			});

			function buildPackHtml(packageId) {

				var innerHtml = '';
				var finalHtml = ''
				if(packageId == 0) {
					innerHtml = '<b class="psi" title="Tiny">T</b><b class="psi" title="Small">S</b><b class="psi" title="Medium">M</b><b class="psi" title="Large">L</b><b class="psi" title="Huge">H</b><b class="psi" title="Angel">A</b>';
				}
				else if(packageId == 1) {
					innerHtml = '<b class="psi psi1" title="Tiny">T</b><b class="psi" title="Small">S</b><b class="psi" title="Medium">M</b><b class="psi" title="Large">L</b><b class="psi" title="Huge">H</b><b class="psi" title="Angel">A</b>';
				}
				else if(packageId == 2) {
					innerHtml = '<b class="psi  psi1" title="Tiny">T</b><b class="psi psi2" title="Small">S</b><b class="psi" title="Medium">M</b><b class="psi" title="Large">L</b><b class="psi" title="Huge">H</b><b class="psi" title="Angel">A</b>';
				}
				else if(packageId == 3) {
					innerHtml = '<b class="psi  psi1" title="Tiny">T</b><b class="psi psi2" title="Small">S</b><b class="psi psi3" title="Medium">M</b><b class="psi" title="Large">L</b><b class="psi" title="Huge">H</b><b class="psi" title="Angel">A</b>';
				}
				else if(packageId == 4) {
					innerHtml = '<b class="psi  psi1" title="Tiny">T</b><b class="psi psi2" title="Small">S</b><b class="psi psi3" title="Medium">M</b><b class="psi psi4" title="Large">L</b><b class="psi" title="Huge">H</b><b class="psi" title="Angel">A</b>';
				}
				else if(packageId == 5) {
					innerHtml = '<b class="psi  psi1" title="Tiny">T</b><b class="psi psi2" title="Small">S</b><b class="psi psi3" title="Medium">M</b><b class="psi psi4" title="Large">L</b><b class="psi psi5" title="Huge">H</b><b class="psi" title="Angel">A</b>';
				}
				else {
					innerHtml = '<b class="psi  psi1" title="Tiny">T</b><b class="psi psi2" title="Small">S</b><b class="psi psi3" title="Medium">M</b><b class="psi psi4" title="Large">L</b><b class="psi psi5" title="Huge">H</b><b class="psi psi6" title="Angel">A</b>';
				}

				finalHtml = '<div class="psg">' + innerHtml + '</div>';

				return finalHtml;
			}

			function buildLoyaltyHtml(loyaltyId) {

				var innerHtml = '';
				var finalHtml = ''
				if(loyaltyId == 0) {
					innerHtml = '<b class="psi" title="Broker">B</b><b class="psi" title="Supervisor">S</b><b class="psi" title="Manager">M</b><b class="psi" title="Executive">E</b><b class="psi" title="President">P</b>';
				}
				else if(loyaltyId == 1) {
					innerHtml = '<b class="psi psr" title="Broker">B</b><b class="psi" title="Supervisor">S</b><b class="psi" title="Manager">M</b><b class="psi" title="Executive">E</b><b class="psi" title="President">P</b>';
				}
				else if(loyaltyId == 2) {
					innerHtml = '<b class="psi psr" title="Broker">B</b><b class="psi psr" title="Supervisor">S</b><b class="psi" title="Manager">M</b><b class="psi" title="Executive">E</b><b class="psi" title="President">P</b>';
				}
				else if(loyaltyId == 3) {
					innerHtml = '<b class="psi psr" title="Broker">B</b><b class="psi psr" title="Supervisor">S</b><b class="psi psr" title="Manager">M</b><b class="psi" title="Executive">E</b><b class="psi" title="President">P</b>';
				}
				else if(loyaltyId == 4) {
					innerHtml = '<b class="psi psr" title="Broker">B</b><b class="psi psr" title="Supervisor">S</b><b class="psi psr" title="Manager">M</b><b class="psi psr" title="Executive">E</b><b class="psi" title="President">P</b>';
				}
				else {
					innerHtml = '<b class="psi psr" title="Broker">B</b><b class="psi psr" title="Supervisor">S</b><b class="psi psr" title="Manager">M</b><b class="psi psr" title="Executive">E</b><b class="psi psr" title="President">P</b>';
				}
				

				finalHtml = '<div class="psg">' + innerHtml + '</div>';

				return finalHtml;
			}

			var to = false;
			$('#search-button').on('click', function (e) {
				$.ajax({
					url: "?action=getUser",
					data: {
						username: $('#search-input').val(),
					},
					timeout : 15000
				}).done(function(data) {
					if (!data.err) {
						$('#genealogy-container').jstree(true).refresh();
					} else {
						swal({
							title: "There's something wrong",
							text: ErrorCodes[data.err],
							type: "error"
						});
					}
				});
			});
			$('#search-input').keypress(function (e) {
				var key = e.which;
				if(key == 13) {
					$('#search-button').click();
					return false;
				}
			});
		});
	</script>
@endsection