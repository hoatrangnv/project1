@extends('adminlte::layouts.member')

@section('htmlheader_title')
	{{ trans('adminlte_lang::member.header_title') }}
@endsection

@section('contentheader_description')
	{{ trans('adminlte_lang::member.binary') }}
@endsection

@section('main-content')
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-body" style="padding-top:0;">
					<div class="chart" id="tree-container"></div>
					<div style="position:absolute; right: 0; top: 0; padding: 20px">
						<button class="btn btn-success btn-xs" type="button" style="float:right; margin-left: 5px" id="refresh-tree"><i class="fa fa-refresh"></i> Refresh</button>
						<button class="btn btn-info btn-xs" type="button" style="float:right" id="go-up"><i class="fa fa-arrow-circle-up"></i> Go Up</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<style>
	  .chart { height: 400px; margin: 5px auto; width: auto; }
	  .Treant > .node {  }
	  .Treant > p { font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif; font-weight: bold; font-size: 12px; }
	  .node-name { font-weight: bold; padding: 3px 0; text-overflow: ellipsis;overflow: hidden;}
	  .tree-node {
		padding: 0;
		-webkit-border-radius: 3px;
		-moz-border-radius: 3px;
		border-radius: 3px;
		background-color: #ffffff;
		border: 1px solid #bbb;
		width: 12%;
		font-size: 10px;
		text-align: center;
		height: 60px;
	  }
	  @media only screen and (max-width: 1024px) {
		.tree-node {
		  font-size: 8px;
		}
	  }
	  @media only screen and (max-width: 768px) {
		.tree-node {
		  font-size: 6px;
		  height: 50px;
		}
	  }
	  .tree-node:hover {
		background-color: #f5f5f5;
	  }
	  .tree-node img {
		margin: 5px 10px 0 5px;
		width: 30px;
		height: 30px;
		border-radius: 50%;
	  }
	  .tree-node p {
		margin-bottom: 3px;
	  }
	</style>
	<link rel="stylesheet" href="{{ asset('/css/jstree.css') }}" />
	<link rel="stylesheet" href="https://app.landcoin.co/libs/treant/Treant.css" />
	
	<script src="https://app.landcoin.co/libs/treant/vendor/raphael.js"></script>
	<script src="https://app.landcoin.co/libs/treant/Treant.js"></script>
	<script src="https://app.landcoin.co/jst.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.15.0/lodash.min.js"></script>
	<script>
		var tmpl = window.JST["assets/templates/tree-node.html"],
          leafTmpl = window.JST["assets/templates/tree-node-leaf.html"];
  $( document ).ready(function() {
    getTree();
    $('#refresh-tree').on('click', function() {
      selectedNodeID = root;
      getTree(null, function(err) {
        if (err) console.log(err);
      })
    });
    $('#go-up').on('click', function() {
      if (parentNode >= root) {
        selectedNodeID = parentNode;
        getTree(parentNode, function(err) {
          if (err) console.log(err);
        })
      }
    });
  });

  var root = 400,
          selectedNodeID = 400,
          parentNode = null;
  var drawTree = function(data) {
    var chart_config = {
      chart: {
        container: "#tree-container",

        connectors: {
          type: 'step',
          style: {
            stroke: '#bbb'
          }
        },
        node: {
          HTMLclass: 'tree-node',
        },
        siblingSeparation: 1,
        subTeeSeparation: 1,
        levelSeparation: 40

      },
      nodeStructure: data,
    }
    new Treant( chart_config, function() {
      $('.tree-node').on('click', function(e) {
        var id = $(this).attr('id');
        if (id) {
          selectedNodeID = id;
          getTree(id, function(err) {
            if (err) console.log(err);
          })
        }
      })
    });
  }

  var getTree = function(id, cb) {
    $.ajax({
      url: "",
      data: {
        id: id,
      },
      timeout : 15000
    }).done(function(data) {
      if (!data.err) {
        var nodeLevel = 0;
        parentNode = data.parentID;
        function fillTree(node) {
          if (node.lvl < 3) {
            if (!node.children) node.children=[];
            if (node.children.length == 0) {
              node.children.push({name: "",levelTitle: null, pkg: -1, weeklySale: -1, avatarURL: 'default-avatar', children:[], pos: 1, level: 0, lMembers: 0, rMembers: 0});
              node.children.push({name: "",levelTitle: null, pkg: -1, weeklySale: -1, avatarURL: 'default-avatar', children:[], pos: 2, level: 0, lMembers: 0, rMembers: 0});
            } else if (node.children.length == 1) {
              if (node.children[0].pos == 1) {
                node.children.push({name: "",levelTitle: null, pkg: -1, weeklySale: -1, avatarURL: 'default-avatar', children:[], pos: 2, level: 0, lMembers: 0, rMembers: 0});
              } else {
                node.children.unshift({name: "",levelTitle: null, pkg: -1, weeklySale: -1, avatarURL: 'default-avatar', children:[], pos: 1, level: 0, lMembers: 0, rMembers: 0});
              }
            }
          }
          if (node.children) {
            for (var i = 0; i < node.children.length; i++) {
              node.children[i].lvl = node.lvl + 1;
              fillTree(node.children[i]);
            }
          }

        }
        function rebuild(node) {
          node.text={username: node.name, pkg: node.weeklySale<0?'':'WS:' + node.weeklySale, leginfo: node.weeklySale < 0?'':'L:' + node.left + ' R:' + node.right, level: node.level, lMembers: node.lMembers, rMembers: node.rMembers};
          if (node.lvl == 3) {
            node.innerHTML = leafTmpl(node.text);
          } else {
            node.innerHTML = tmpl(node.text);
          }
          node.HTMLid = node.id;
          if (node.children) {
            for (var i = 0; i < node.children.length; i++) {
              rebuild(node.children[i]);
            }
          }
        }
        data.lvl = 0;
        fillTree(data);
        rebuild(data);
        $('#tree-container').removeClass('Treant');
        $('#tree-container').removeClass('Treant-loaded');
        $('#tree-container').html('');
        if (data) drawTree(data);
      } else {
        if (cb) cb(data.err);
      }
    });
  }
	</script>
@endsection