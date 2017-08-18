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
												pkg: '$' + user.pkg,
												numMember: user.dmc,
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
											pkg: '$' + user.pkg,
											numMember: user.dmc,
											level: user.l,
										},
										id: user.id,
										children: user.dmc?true:false,
										icon: "/img/jstree/user.png",
										state: {opened: false}
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
						{width: '5%', value: "numMember", header: "Total member"},
						{width: '5%', value: "pkg", header: "Active Package"},
						{width: '2%', value: "level", header: "Loyalty"},
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

			$(document).on('click', '.ph-history', function(){
				var id = $(this).parent().parent().attr('id');
				$.ajax({
					url: "/getPackageHistory",
					type: "POST",
					data: {
					userid: id,
					_csrf: 'LP3m3qBE-6j1VNbd4i7NgiJrZ-LaLF-oo7N0'
					},
					timeout : 15000
				}).done(function(data) {
					if (!data.err) {
						var username = $('#genealogy-container').jstree(true).get_node(id).data.username;
						$('#ph-history-username').text(username);
						$('#ph-history-content').html('');
						var index = 1;
						data.phs.forEach(function(ph) {
							ph.index = index++;
							var phItem = phItemTemplate(ph);
							$('#ph-history-content').append(phItem);
						});
						$('#ph-history-modal').modal('show');
					} else {
						swal({
							title: "There's something wrong",
							text: ErrorCodes[data.err],
							type: "error"
						});
					}
				});
			});
			$(document).on('click', '.downline-stats', function(){
				var id = $(this).parent().parent().attr('id');
				$.ajax({
					url: "/getDownlinePHStats",
					type: "POST",
					data: {
						userid: id,
					},
					timeout : 15000
				}).done(function(data) {
					if (!data.err) {
						var username = $('#genealogy-container').jstree(true).get_node(id).data.username;
						$('#downline-stats-username').text(username);
						$('#downline-stats-content').html('');
						var index = 1;
						for (var i = 0; i < data.length; i++) {
							if (data[i]) {
								var item = {amount: data[i].toFixed(3)};
								item.index = index++;
								var d = moment('2016-08', 'YYYY-MM');
								item.month = d.add(i, 'month').format('MM/YYYY');
								var phItem = downlinePHItemTemplate(item);
								$('#downline-stats-content').append(phItem);
							}
						}
						$('#downline-stats-modal').modal('show');
					} else {
						swal({
							title: "There's something wrong",
							text: ErrorCodes[data.err],
							type: "error"
						});
					}
				});
			});	
		});
	</script>
@endsection