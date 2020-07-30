(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[5],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/MyProfile.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/MyProfile.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _components_ProfileCard__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../components/ProfileCard */ "./resources/js/components/ProfileCard.vue");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'MyProfile',
  data: function data() {
    return {
      editMode: true,
      profileLoading: false,
      profileData: {}
    };
  },
  methods: {
    getProfileData: function getProfileData() {
      var _this = this;

      this.profileLoading = true;
      var data = window.axios.get('/api/kpbi/profile').then(function (_ref) {
        var data = _ref.data;
        _this.profileLoading = false;
        return data;
      })["catch"](function (_ref2) {
        var err = _ref2.data;
        return err;
      });
      this.profileData = data;
    },
    save: function save() {
      console.log('saved!');
    }
  },
  mounted: function mounted() {
    this.getProfileData();
  },
  components: {
    ProfileCard: _components_ProfileCard__WEBPACK_IMPORTED_MODULE_0__["default"]
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/MyProfile.vue?vue&type=template&id=8e9c9464&":
/*!*******************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/MyProfile.vue?vue&type=template&id=8e9c9464& ***!
  \*******************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "v-container",
    { attrs: { fluid: "" } },
    [
      _c(
        "v-row",
        { attrs: { justify: "center" } },
        [
          _c("ProfileCard", {
            attrs: {
              editMode: _vm.editMode,
              profileData: _vm.profileData,
              isLoading: _vm.profileLoading
            }
          })
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "v-tooltip",
        {
          attrs: { top: "" },
          scopedSlots: _vm._u([
            {
              key: "activator",
              fn: function(ref) {
                var on = ref.on
                var attrs = ref.attrs
                return [
                  _c(
                    "v-fab-transition",
                    [
                      _c(
                        "v-btn",
                        _vm._g(
                          _vm._b(
                            {
                              directives: [
                                {
                                  name: "show",
                                  rawName: "v-show",
                                  value: _vm.editMode,
                                  expression: "editMode"
                                }
                              ],
                              attrs: {
                                fab: "",
                                fixed: "",
                                bottom: "",
                                right: "",
                                color: "green",
                                dark: "",
                                disabled: ""
                              },
                              on: { click: _vm.save }
                            },
                            "v-btn",
                            attrs,
                            false
                          ),
                          on
                        ),
                        [_c("v-icon", [_vm._v("mdi-check")])],
                        1
                      )
                    ],
                    1
                  )
                ]
              }
            }
          ])
        },
        [_vm._v(" "), _c("span", [_vm._v("Save")])]
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/views/MyProfile.vue":
/*!******************************************!*\
  !*** ./resources/js/views/MyProfile.vue ***!
  \******************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _MyProfile_vue_vue_type_template_id_8e9c9464___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./MyProfile.vue?vue&type=template&id=8e9c9464& */ "./resources/js/views/MyProfile.vue?vue&type=template&id=8e9c9464&");
/* harmony import */ var _MyProfile_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./MyProfile.vue?vue&type=script&lang=js& */ "./resources/js/views/MyProfile.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _MyProfile_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _MyProfile_vue_vue_type_template_id_8e9c9464___WEBPACK_IMPORTED_MODULE_0__["render"],
  _MyProfile_vue_vue_type_template_id_8e9c9464___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/MyProfile.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/MyProfile.vue?vue&type=script&lang=js&":
/*!*******************************************************************!*\
  !*** ./resources/js/views/MyProfile.vue?vue&type=script&lang=js& ***!
  \*******************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_MyProfile_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./MyProfile.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/MyProfile.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_MyProfile_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/MyProfile.vue?vue&type=template&id=8e9c9464&":
/*!*************************************************************************!*\
  !*** ./resources/js/views/MyProfile.vue?vue&type=template&id=8e9c9464& ***!
  \*************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_MyProfile_vue_vue_type_template_id_8e9c9464___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./MyProfile.vue?vue&type=template&id=8e9c9464& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/MyProfile.vue?vue&type=template&id=8e9c9464&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_MyProfile_vue_vue_type_template_id_8e9c9464___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_MyProfile_vue_vue_type_template_id_8e9c9464___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);