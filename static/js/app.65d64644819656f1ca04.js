webpackJsonp([10],{NHnr:function(n,e,t){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var r=t("//Fk"),i=t.n(r),o=t("7+uW"),u=t("/ocq");o.default.use(u.a);var a=new u.a({routes:[{path:"/login",name:"Login",component:function(){return t.e(4).then(t.bind(null,"xJsL"))},hidden:!0},{path:"/test",name:"Test",component:function(){return t.e(6).then(t.bind(null,"ua3t"))},hidden:!0},{path:"/about",name:"About",component:function(){return t.e(8).then(t.bind(null,"c27y"))},hidden:!0},{path:"/explain",name:"Explain",component:function(){return t.e(7).then(t.bind(null,"NtYA"))},hidden:!0},{path:"/",name:"信息中心",component:function(){return t.e(0).then(t.bind(null,"Mtml"))},redirect:"/dashboard",meta:{requireLogin:!0},children:[{path:"dashboard",name:"Dashboard",component:function(){return t.e(3).then(t.bind(null,"TGvd"))},hidden:!0}]},{path:"/mo",name:"京东钼媒",redirect:"device/list",meta:{requireLogin:!0},component:function(){return t.e(0).then(t.bind(null,"Mtml"))},children:[{path:"device/list",name:"关联设备",component:function(){return t.e(1).then(t.bind(null,"pY6z"))}},{path:"ads/list",name:"钼媒订单",component:function(){return t.e(2).then(t.bind(null,"/EqR"))}},{path:"device/detail",name:"设备详情",component:function(){return t.e(5).then(t.bind(null,"V5A4"))}}]},{path:"/jupingx",name:"百度聚屏",redirect:"device/list",meta:{requireLogin:!0},component:function(){return t.e(0).then(t.bind(null,"Mtml"))},children:[{path:"device/list",name:"设备列表",component:function(){return t.e(1).then(t.bind(null,"pY6z"))}},{path:"ads/list",name:"广告订单",component:function(){return t.e(2).then(t.bind(null,"/EqR"))}}]}]}),c=t("zL8q"),l=t.n(c),d=(t("tvR6"),{render:function(){var n=this.$createElement,e=this._self._c||n;return e("div",{attrs:{id:"app"}},[e("router-view")],1)},staticRenderFns:[]});var p=t("VU/8")({name:"App"},d,!1,function(n){t("aGOF")},null,null).exports,h=t("mtWM"),s=t.n(h);s.a.defaults.baseURL="http://localhost:8081",s.a.interceptors.request.use(function(n){return n},function(n){return i.a.reject(n)}),s.a.interceptors.response.use(function(n){return n},function(n){return i.a.reject(n)}),o.default.use(l.a),a.beforeEach(function(n,e,t){n.matched.some(function(n){return n.meta.requireLogin})?sessionStorage.getItem("userInfo")?t():t({path:"/login"}):t()}),o.default.config.productionTip=!1,new o.default({el:"#app",router:a,components:{App:p},template:"<App/>"})},aGOF:function(n,e){},tvR6:function(n,e){}},["NHnr"]);
//# sourceMappingURL=app.65d64644819656f1ca04.js.map