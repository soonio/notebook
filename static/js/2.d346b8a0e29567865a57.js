webpackJsonp([2],{"/EqR":function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var r=n("FJR+"),a=n("//Fk"),l=n.n(a),i=n("mtWM"),o=n.n(i),s=n("zL8q"),c=o.a.create({baseURL:"https://api-dev",timeout:5e3});c.interceptors.request.use(function(e){return e},function(e){console.log(e),l.a.reject(e)}),c.interceptors.response.use(function(e){return e},function(e){return console.log("err"+e),Object(s.Message)({message:e.message,type:"error",duration:5e3}),l.a.reject(e)});var u=c;var d={data:function(){return{lists:[]}},created:function(){var e,t=this;(e={},u({url:"/mo/order",method:"post",params:e})).then(function(e){t.lists=[],e.data.list.forEach(function(e){t.lists.push(e)})})},components:{Pagination:r.a},methods:{dateFormat:function(e,t,n,r){return function(e){if(0===e||null==e||""===e)return"-";var t=new Date(1e3*e);return t.getFullYear()+"-"+(t.getMonth()+1<10?"0"+(t.getMonth()+1):t.getMonth()+1)+"-"+(t.getDate()<10?"0"+t.getDate():t.getDate())+" "+(t.getHours()<10?"0"+t.getHours():t.getHours())+":"+(t.getMinutes()<10?"0"+t.getMinutes():t.getMinutes())+":"+(t.getSeconds()<10?"0"+t.getSeconds():t.getSeconds())}(e[t.property])},addSeconds:function(e,t,n,r){return e[t.property]+"s"}}},p={render:function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",[n("el-row",{attrs:{gutter:20}},[n("el-col",{attrs:{span:1}},[n("div",{staticClass:"grid-content"})]),e._v(" "),n("el-col",{attrs:{span:22}},[n("div",{staticClass:"grid-content"},[n("el-table",{staticStyle:{width:"100%"},attrs:{data:e.lists,height:"600"}},[n("el-table-column",{attrs:{align:"center",prop:"id",label:"ID",width:"50",fixed:""}}),e._v(" "),n("el-table-column",{attrs:{align:"center",prop:"order_id",label:"订单号"}}),e._v(" "),n("el-table-column",{attrs:{align:"center",prop:"duration",label:"播放时长",formatter:e.addSeconds}}),e._v(" "),n("el-table-column",{attrs:{align:"center",prop:"play_num",label:"保底播放次数"}}),e._v(" "),n("el-table-column",{attrs:{align:"center",prop:"start_time",label:"开始时间",width:"150",formatter:e.dateFormat}}),e._v(" "),n("el-table-column",{attrs:{align:"center",prop:"end_time",label:"结束时间",width:"150",formatter:e.dateFormat}}),e._v(" "),n("el-table-column",{attrs:{align:"center",label:"是否确认"},scopedSlots:e._u([{key:"default",fn:function(t){return[1===t.row.confirmed?n("el-button",{attrs:{type:"success",icon:"el-icon-check",size:"mini",circle:""}}):e._e(),e._v(" "),0===t.row.confirmed?n("el-button",{attrs:{type:"warning",icon:"el-icon-loading",size:"mini",circle:""}}):e._e()]}}])}),e._v(" "),n("el-table-column",{attrs:{align:"center",label:"是否支付"},scopedSlots:e._u([{key:"default",fn:function(t){return[1===t.row.payed?n("el-button",{attrs:{type:"success",icon:"el-icon-check",size:"mini",circle:""}}):e._e(),e._v(" "),-1===t.row.payed?n("el-button",{attrs:{type:"warning",icon:"el-icon-loading",size:"mini",circle:""}}):e._e(),e._v(" "),0===t.row.payed?n("el-button",{attrs:{type:"danger",icon:"el-icon-close",size:"mini",circle:""}}):e._e()]}}])}),e._v(" "),n("el-table-column",{attrs:{align:"center",label:"是否发布"},scopedSlots:e._u([{key:"default",fn:function(t){return[1===t.row.release?n("el-button",{attrs:{type:"success",icon:"el-icon-check",size:"mini",circle:""}}):e._e(),e._v(" "),-1===t.row.release?n("el-button",{attrs:{type:"warning",icon:"el-icon-loading",size:"mini",circle:""}}):e._e(),e._v(" "),0===t.row.release?n("el-button",{attrs:{type:"danger",icon:"el-icon-close",size:"mini",circle:""}}):e._e()]}}])}),e._v(" "),n("el-table-column",{attrs:{align:"center",prop:"created_at",label:"创建时间",width:"150"}}),e._v(" "),n("el-table-column",{attrs:{align:"center",prop:"updated_at",label:"更新时间",width:"150"}})],1)],1)])],1),e._v(" "),n("Pagination")],1)},staticRenderFns:[]};var g=n("VU/8")(d,p,!1,function(e){n("Ziyb")},null,null);t.default=g.exports},"FJR+":function(e,t,n){"use strict";var r={render:function(){var e=this.$createElement,t=this._self._c||e;return t("el-row",{attrs:{gutter:20}},[t("el-col",{attrs:{span:1}},[t("div",{staticClass:"grid-content"})]),this._v(" "),t("el-col",{attrs:{span:22}},[t("div",{staticClass:"block"},[t("el-pagination",{attrs:{layout:"prev, pager, next",total:1e3}})],1)]),this._v(" "),t("el-col",{attrs:{span:1}},[t("div",{staticClass:"grid-content"})])],1)},staticRenderFns:[]};var a=n("VU/8")({data:function(){return{}}},r,!1,function(e){n("sUww")},"data-v-e0a18200",null);t.a=a.exports},Ziyb:function(e,t){},sUww:function(e,t){}});
//# sourceMappingURL=2.d346b8a0e29567865a57.js.map