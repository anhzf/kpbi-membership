(window.webpackJsonp=window.webpackJsonp||[]).push([[4],{bR8p:function(t,e,i){"use strict";i.r(e);var s=i("o0o1"),r=i.n(s);function a(t,e,i,s,r,a,n){try{var c=t[a](n),o=c.value}catch(t){return void i(t)}c.done?e(o):Promise.resolve(o).then(s,r)}var n={name:"AccountSettings",computed:{verified:function(){return this.$store.getters.userVerified}},methods:{sendEmailVerification:function(){var t,e=this;return(t=r.a.mark((function t(){var i,s;return r.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return e.$store.commit("contentLoading",!0),t.prev=1,t.next=4,window.axios("/verify/resend");case 4:i=t.sent,s=i.data.message,e.$emit("notice",{message:s,type:"success"}),t.next=12;break;case 9:t.prev=9,t.t0=t.catch(1),e.$emit("noticeError",t.t0);case 12:e.$store.commit("contentLoading",!1);case 13:case"end":return t.stop()}}),t,null,[[1,9]])})),function(){var e=this,i=arguments;return new Promise((function(s,r){var n=t.apply(e,i);function c(t){a(n,s,r,c,o,"next",t)}function o(t){a(n,s,r,c,o,"throw",t)}c(void 0)}))})()}}},c=i("KHd+"),o=Object(c.a)(n,(function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("v-row",{staticClass:"pa-10",attrs:{align:"center",justify:"center"}},[i("v-card",{attrs:{width:"100%","max-width":"650"}},[i("v-list",[i("v-list-item",{class:[t.verified?"success":"error","lighten-5","pa-4"]},[i("v-list-item-avatar",[t.verified?i("v-icon",{attrs:{color:"success"}},[t._v("mdi-check")]):i("v-icon",{attrs:{color:"error"}},[t._v("mdi-close")])],1),t._v(" "),i("v-list-item-content",[t.verified?i("v-list-item-title",[t._v("Terverifikasi")]):i("v-list-item-title",[t._v("Belum terverifikasi")]),t._v(" "),t.verified?t._e():i("v-list-item-subtitle",[i("v-btn",{attrs:{text:"","x-small":""},on:{click:t.sendEmailVerification}},[t._v("Kirim email verifikasi")])],1)],1)],1),t._v(" "),i("v-list-item",{attrs:{ripple:""}},[i("v-list-item-content",[i("v-row",{staticClass:"px-6"},[i("v-col",{staticClass:"grey--text text--darken-1",attrs:{sm:"3"}},[t._v("Email")]),t._v(" "),i("v-col",{staticClass:"text-right grey--text"},[t._v(t._s(t.$store.getters.userEmail))])],1)],1)],1),t._v(" "),i("v-list-item",{attrs:{ripple:""}},[i("v-list-item-content",[i("v-row",{staticClass:"px-6"},[i("v-col",{staticClass:"grey--text text--darken-1",attrs:{sm:"3"}},[t._v("Username")]),t._v(" "),i("v-col",{staticClass:"text-right"},[t._v(t._s(t.$store.getters.userName))])],1)],1)],1),t._v(" "),i("v-list-item",[i("v-list-item-content",[i("v-row",{staticClass:"px-6",attrs:{align:"center"}},[i("v-col",{staticClass:"grey--text text--darken-1",attrs:{sm:"3"}},[t._v("Password")]),t._v(" "),i("v-col",{staticClass:"text-right"},[i("v-btn",{attrs:{text:"",small:"",color:"grey darken-2"},on:{click:function(e){return t.$emit("notice",{message:"Fitur ini masih dalam tahap konstruksi"})}}},[i("v-icon",{attrs:{small:""}},[t._v("mdi-pencil")]),t._v("\r\n                                Ubah password\r\n                            ")],1)],1)],1)],1)],1)],1)],1)],1)}),[],!1,null,null,null);e.default=o.exports}}]);