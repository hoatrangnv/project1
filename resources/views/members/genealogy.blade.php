@extends('adminlte::layouts.member')

@section('htmlheader_title')
	{{ trans('adminlte_lang::member.header_title') }}
@endsection

@section('contentheader_description')
	{{ trans('adminlte_lang::member.genealogy') }}
@endsection

@section('main-content')
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<label for="inputEmail3" class="col-sm-2 no-padding"><h5>{{ trans('adminlte_lang::member.search_title') }}</h5></label>
					<div class="col-sm-3 no-padding">
						<div class="input-group input-group-sm">
							<input type="text" class="form-control" placeholder="E.g JohnDoe" id="search-input">
							<span class="input-group-btn">
								<button type="button" id="search-button" class="btn btn-primary btn-flat"><i class="fa fa-search"></i> {{ trans('adminlte_lang::member.btn_search') }}</button>
							</span>
						</div>
					</div>
				</div>
				<div class="box-body" style="padding-top:0;">
					<div id="genealogy-container" style="min-width: 150px; min-height: 100px; overflow: auto;"></div>
				</div>
			</div>
		</div>
	</div>
	<link rel="stylesheet" href="{{ asset('/css/jstree.css') }}" />
	<script src="{{ asset('/js/jstree.min.js') }}"></script>
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
											text: user.id +' '+ user.u,
											data: {
												username: user.id +' '+ user.u,
                                                packageId: user.packageId,
                                                totalMembers: user.totalMembers,
                                                leg: user.leg,
                                                loyaltyId: user.loyaltyId,
												level: user.l,
											},
											id: user.id,
											children: user.dmc?true:false,
											icon: "/img/jstree/user.png",
											state: {opened: false}
										});
									}
									cb(children);
								} else {
									var user = data;
									cb([{
										text: user.id +' '+ user.u,
										data: {
											username: user.id +' '+ user.u,
                                            packageId: user.packageId,
                                            totalMembers: user.totalMembers,
                                            leg: user.leg,
                                            loyaltyId: user.loyaltyId,
											level: user.l,
										},
										id: user.id,
										children: user.dmc?true:false,
										icon: "/img/jstree/user.png",
										state: {opened: true}
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
					],
					width: "100%",
					resizable: true,
					draggable: true,
				}
			});
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