this["JST"] = this["JST"] || {};
this["JST"]["assets/templates/tree-node-leaf.html"] = function(obj) {
    obj || (obj = {});
    var __t, __p = '',
        __e = _.escape;
    with(obj) {
        __p += '<div class="node-loyalty node-loyalty-'+loyaltyId+'"><div class="node-name node-lvl-' +
            ((__t = (level)) == null ? '' : __t) + '"' + (username == '' ? '' : 'style="border-bottom: 1px solid; color: #3c8dbc"') + '>' + (username == '' ? '' : '<i class="fa fa-user" style="margin-right: 3px; color: gold"></i>') +
            ((__t = (username)) == null ? '' : __t) + '</div>\n<p class="node-title">' +
            ((__t = (pkg)) == null ? '' : __t) + '</p>\n<p class="node-contact">' +
            ((__t = (leginfo)) == null ? '' : __t) + '</p></div>\n';
    }
    return __p
};
this["JST"]["assets/templates/tree-node.html"] = function(obj) {
    obj || (obj = {});
    var __t, __p = '',
        __e = _.escape;
    with(obj) {
        __p += '<div class="node-loyalty node-loyalty-'+loyaltyId+'"><div class="node-name node-lvl-' +
            ((__t = (level)) == null ? '' : __t) + '"' +  (username == '' ? '' : 'style="border-bottom: 1px solid; color: #3c8dbc"') +'>' + (username == '' ? '' : '<i class="fa fa-user" style="margin-right: 3px; color: gold"></i>') +
            ((__t = (username)) == null ? '' : __t) + '</div>\n<p class="node-title">' +
            ((__t = (pkg)) == null ? '' : __t) + '</p>\n<p class="node-contact">' +
            ((__t = (leginfo)) == null ? '' : __t) + '</p>\n<div style="position: absolute;bottom: -18px; width: 100%;"><div style="width: 50%;text-align: right; padding-right: 10px; float: left">' +
            ((__t = (lMembers)) == null ? '' : __t) + '</div><div style="width: 50%;text-align: left; padding-left: 10px; float: left">' +
            ((__t = (rMembers)) == null ? '' : __t) + '</div></div></div>\n';
    }
    return __p
};