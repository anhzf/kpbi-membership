(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[1],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/ChangePasswordDialog.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/ChangePasswordDialog.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _util_Validator__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @/util/Validator */ "./resources/js/util/Validator.js");


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

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
  name: 'ChangePasswordDialog',
  props: {
  value: {
    required: true,
    type: Boolean
  }
  },
  data: function data() {
  return {
    changePasswordOnProgress: false,
    oldPassword: null,
    showOldPassword: null,
    newPassword: null,
    showNewPassword: null,
    newPassword_confirmation: null,
    required: _util_Validator__WEBPACK_IMPORTED_MODULE_1__["required"]
  };
  },
  methods: {
  changePassword: function changePassword() {
    var _this = this;

    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee() {
    var changePassword, _yield$window$axios$p, message;

    return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
      while (1) {
      switch (_context.prev = _context.next) {
        case 0:
        _this.changePasswordOnProgress = true;
        changePassword = {
          oldPassword: _this.oldPassword,
          newPassword: _this.newPassword,
          newPassword_confirmation: _this.newPassword_confirmation
        };

        _this.$refs.changePasswordForm.reset();

        _this.$refs.changePasswordForm.resetValidation();

        _context.prev = 4;
        _context.next = 7;
        return window.axios.put('/api/auth/user/change-password', changePassword);

        case 7:
        _yield$window$axios$p = _context.sent;
        message = _yield$window$axios$p.data.message;

        _this.$emit('notice', {
          message: message,
          type: 'success'
        });

        _context.next = 15;
        break;

        case 12:
        _context.prev = 12;
        _context.t0 = _context["catch"](4);

        _this.$emit('noticeError', _context.t0);

        case 15:
        _this.$emit('input', false);

        _this.changePasswordOnProgress = false;

        case 17:
        case "end":
        return _context.stop();
      }
      }
    }, _callee, null, [[4, 12]]);
    }))();
  }
  } // watch: {
  // toggleChangePassword() {
  //   if (!this.toggleChangePassword) {
  //     this.$refs.changePasswordForm.reset()
  //     this.$refs.changePasswordForm.resetValidation()
  //   }
  // }
  // }

});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/AccountSettings.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/AccountSettings.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _components_ChangePasswordDialog__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @/components/ChangePasswordDialog */ "./resources/js/components/ChangePasswordDialog.vue");
/* harmony import */ var _util_Validator__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @/util/Validator */ "./resources/js/util/Validator.js");


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

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
//
//
//
//
//
//


/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'AccountSettings',
  data: function data() {
  return {
    showChangePasswordDialog: false
  };
  },
  computed: {
  verified: function verified() {
    return this.$store.getters.userVerified;
  }
  },
  methods: {
  sendEmailVerification: function sendEmailVerification() {
    var _this = this;

    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee() {
    var _yield$window$axios, message;

    return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
      while (1) {
      switch (_context.prev = _context.next) {
        case 0:
        _this.$store.commit('contentLoading', true);

        _context.prev = 1;
        _context.next = 4;
        return window.axios('/verify/resend');

        case 4:
        _yield$window$axios = _context.sent;
        message = _yield$window$axios.data.message;

        _this.$emit('notice', {
          message: message,
          type: 'success'
        });

        _context.next = 12;
        break;

        case 9:
        _context.prev = 9;
        _context.t0 = _context["catch"](1);

        _this.$emit('noticeError', _context.t0);

        case 12:
        _this.$store.commit('contentLoading', false);

        case 13:
        case "end":
        return _context.stop();
      }
      }
    }, _callee, null, [[1, 9]]);
    }))();
  }
  },
  components: {
  ChangePasswordDialog: _components_ChangePasswordDialog__WEBPACK_IMPORTED_MODULE_1__["default"]
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/ChangePasswordDialog.vue?vue&type=template&id=c461c204&":
/*!***********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/ChangePasswordDialog.vue?vue&type=template&id=c461c204& ***!
  \***********************************************************************************************************************************************************************************************************************/
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
  "v-dialog",
  {
    attrs: {
    value: _vm.value,
    width: "450",
    "max-width": "100%",
    persistent: _vm.changePasswordOnProgress
    },
    on: {
    input: function($event) {
      return _vm.$emit("input", $event)
    }
    }
  },
  [
    _c(
    "v-card",
    [
      !_vm.changePasswordOnProgress
      ? _c("v-card-title", [_vm._v("Ubah Password")])
      : _vm._e(),
      _vm._v(" "),
      _c(
      "v-card-text",
      [
        _c(
        "v-container",
        { attrs: { fluid: "" } },
        [
          _c(
          "v-row",
          { attrs: { justify: "center", align: "center" } },
          [
            _vm.changePasswordOnProgress
            ? _c("v-progress-circular", {
              attrs: {
                indeterminate: _vm.changePasswordOnProgress
              }
              })
            : _c(
              "v-col",
              [
                _c(
                "v-form",
                { ref: "changePasswordForm" },
                [
                  _c("v-text-field", {
                  attrs: {
                    label: "Password Lama",
                    type: _vm.showOldPassword
                    ? "text"
                    : "password",
                    "append-icon": _vm.showOldPassword
                    ? "mdi-eye"
                    : "mdi-eye-off",
                    rules: [_vm.required]
                  },
                  on: {
                    "click:append": function($event) {
                    _vm.showOldPassword = !_vm.showOldPassword
                    }
                  },
                  model: {
                    value: _vm.oldPassword,
                    callback: function($$v) {
                    _vm.oldPassword = $$v
                    },
                    expression: "oldPassword"
                  }
                  }),
                  _vm._v(" "),
                  _c("v-text-field", {
                  attrs: {
                    label: "Password baru",
                    type: _vm.showNewPassword
                    ? "text"
                    : "password",
                    "append-icon": _vm.showNewPassword
                    ? "mdi-eye"
                    : "mdi-eye-off",
                    rules: [_vm.required]
                  },
                  on: {
                    "click:append": function($event) {
                    _vm.showNewPassword = !_vm.showNewPassword
                    }
                  },
                  model: {
                    value: _vm.newPassword,
                    callback: function($$v) {
                    _vm.newPassword = $$v
                    },
                    expression: "newPassword"
                  }
                  }),
                  _vm._v(" "),
                  _c("v-text-field", {
                  attrs: {
                    label: "Ulangi password baru",
                    type: _vm.showNewPassword
                    ? "text"
                    : "password",
                    rules: [_vm.required]
                  },
                  model: {
                    value: _vm.newPassword_confirmation,
                    callback: function($$v) {
                    _vm.newPassword_confirmation = $$v
                    },
                    expression: "newPassword_confirmation"
                  }
                  })
                ],
                1
                )
              ],
              1
              )
          ],
          1
          )
        ],
        1
        )
      ],
      1
      ),
      _vm._v(" "),
      !_vm.changePasswordOnProgress
      ? _c(
        "v-card-actions",
        [
          _c("v-spacer"),
          _vm._v(" "),
          _c(
          "v-btn",
          {
            attrs: { color: "grey darken-1", text: "" },
            on: {
            click: function($event) {
              return _vm.$emit("input", false)
            }
            }
          },
          [_vm._v("Close")]
          ),
          _vm._v(" "),
          _c(
          "v-btn",
          {
            attrs: { color: "blue darken-1", text: "" },
            on: { click: _vm.changePassword }
          },
          [_vm._v("Save")]
          )
        ],
        1
        )
      : _vm._e()
    ],
    1
    )
  ],
  1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/AccountSettings.vue?vue&type=template&id=4dce3ebe&":
/*!*************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/AccountSettings.vue?vue&type=template&id=4dce3ebe& ***!
  \*************************************************************************************************************************************************************************************************************/
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
  "v-row",
  { staticClass: "pa-10", attrs: { align: "center", justify: "center" } },
  [
    _c(
    "v-card",
    { attrs: { width: "100%", "max-width": "650" } },
    [
      _c(
      "v-list",
      [
        _c(
        "v-list-item",
        {
          class: [
          _vm.verified ? "success" : "error",
          "lighten-5",
          "pa-4"
          ]
        },
        [
          _c(
          "v-list-item-avatar",
          [
            _vm.verified
            ? _c("v-icon", { attrs: { color: "success" } }, [
              _vm._v("mdi-check")
              ])
            : _c("v-icon", { attrs: { color: "error" } }, [
              _vm._v("mdi-close")
              ])
          ],
          1
          ),
          _vm._v(" "),
          _c(
          "v-list-item-content",
          [
            _vm.verified
            ? _c("v-list-item-title", [_vm._v("Terverifikasi")])
            : _c("v-list-item-title", [
              _vm._v("Belum terverifikasi")
              ]),
            _vm._v(" "),
            !_vm.verified
            ? _c(
              "v-list-item-subtitle",
              [
                _c(
                "v-btn",
                {
                  attrs: { text: "", "x-small": "" },
                  on: { click: _vm.sendEmailVerification }
                },
                [_vm._v("Kirim email verifikasi")]
                )
              ],
              1
              )
            : _vm._e()
          ],
          1
          )
        ],
        1
        ),
        _vm._v(" "),
        _c(
        "v-list-item",
        { attrs: { ripple: "" } },
        [
          _c(
          "v-list-item-content",
          [
            _c(
            "v-row",
            { staticClass: "px-6" },
            [
              _c(
              "v-col",
              {
                staticClass: "grey--text text--darken-1",
                attrs: { sm: "3" }
              },
              [_vm._v("Email")]
              ),
              _vm._v(" "),
              _c(
              "v-col",
              { staticClass: "text-right grey--text" },
              [_vm._v(_vm._s(_vm.$store.getters.userEmail))]
              )
            ],
            1
            )
          ],
          1
          )
        ],
        1
        ),
        _vm._v(" "),
        _c(
        "v-list-item",
        { attrs: { ripple: "" } },
        [
          _c(
          "v-list-item-content",
          [
            _c(
            "v-row",
            { staticClass: "px-6" },
            [
              _c(
              "v-col",
              {
                staticClass: "grey--text text--darken-1",
                attrs: { sm: "3" }
              },
              [_vm._v("Username")]
              ),
              _vm._v(" "),
              _c("v-col", { staticClass: "text-right" }, [
              _vm._v(_vm._s(_vm.$store.getters.userName))
              ])
            ],
            1
            )
          ],
          1
          )
        ],
        1
        ),
        _vm._v(" "),
        _c(
        "v-list-item",
        [
          _c(
          "v-list-item-content",
          [
            _c(
            "v-row",
            { staticClass: "px-6", attrs: { align: "center" } },
            [
              _c(
              "v-col",
              {
                staticClass: "grey--text text--darken-1",
                attrs: { sm: "3" }
              },
              [_vm._v("Password")]
              ),
              _vm._v(" "),
              _c(
              "v-col",
              { staticClass: "text-right" },
              [
                _c(
                "v-btn",
                {
                  attrs: {
                  text: "",
                  small: "",
                  color: "grey darken-2"
                  },
                  on: {
                  click: function($event) {
                    _vm.showChangePasswordDialog = !_vm.showChangePasswordDialog
                  }
                  }
                },
                [
                  _c("v-icon", { attrs: { small: "" } }, [
                  _vm._v("mdi-pencil")
                  ]),
                  _vm._v(
                  "\r\n                Ubah password\r\n              "
                  )
                ],
                1
                )
              ],
              1
              )
            ],
            1
            )
          ],
          1
          )
        ],
        1
        )
      ],
      1
      )
    ],
    1
    ),
    _vm._v(" "),
    _c("change-password-dialog", {
    on: {
      notice: function($event) {
      return _vm.$emit("notice", $event)
      },
      noticeError: function($event) {
      return _vm.$emit("noticeError", $event)
      }
    },
    model: {
      value: _vm.showChangePasswordDialog,
      callback: function($$v) {
      _vm.showChangePasswordDialog = $$v
      },
      expression: "showChangePasswordDialog"
    }
    })
  ],
  1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/ChangePasswordDialog.vue":
/*!**********************************************************!*\
  !*** ./resources/js/components/ChangePasswordDialog.vue ***!
  \**********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ChangePasswordDialog_vue_vue_type_template_id_c461c204___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ChangePasswordDialog.vue?vue&type=template&id=c461c204& */ "./resources/js/components/ChangePasswordDialog.vue?vue&type=template&id=c461c204&");
/* harmony import */ var _ChangePasswordDialog_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ChangePasswordDialog.vue?vue&type=script&lang=js& */ "./resources/js/components/ChangePasswordDialog.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _ChangePasswordDialog_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ChangePasswordDialog_vue_vue_type_template_id_c461c204___WEBPACK_IMPORTED_MODULE_0__["render"],
  _ChangePasswordDialog_vue_vue_type_template_id_c461c204___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null

)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ChangePasswordDialog.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/ChangePasswordDialog.vue?vue&type=script&lang=js&":
/*!***********************************************************************************!*\
  !*** ./resources/js/components/ChangePasswordDialog.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ChangePasswordDialog_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./ChangePasswordDialog.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/ChangePasswordDialog.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ChangePasswordDialog_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]);

/***/ }),

/***/ "./resources/js/components/ChangePasswordDialog.vue?vue&type=template&id=c461c204&":
/*!*****************************************************************************************!*\
  !*** ./resources/js/components/ChangePasswordDialog.vue?vue&type=template&id=c461c204& ***!
  \*****************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ChangePasswordDialog_vue_vue_type_template_id_c461c204___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./ChangePasswordDialog.vue?vue&type=template&id=c461c204& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/ChangePasswordDialog.vue?vue&type=template&id=c461c204&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ChangePasswordDialog_vue_vue_type_template_id_c461c204___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ChangePasswordDialog_vue_vue_type_template_id_c461c204___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/util/Validator.js":
/*!****************************************!*\
  !*** ./resources/js/util/Validator.js ***!
  \****************************************/
/*! exports provided: required, email */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "required", function() { return required; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "email", function() { return email; });
var required = function required(v) {
  return !!v || 'Wajib diisi';
},
  email = function email(v) {
  return /.+@.+\..+/.test(v) || 'E-mail tidak valid';
};



/***/ }),

/***/ "./resources/js/views/AccountSettings.vue":
/*!************************************************!*\
  !*** ./resources/js/views/AccountSettings.vue ***!
  \************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _AccountSettings_vue_vue_type_template_id_4dce3ebe___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./AccountSettings.vue?vue&type=template&id=4dce3ebe& */ "./resources/js/views/AccountSettings.vue?vue&type=template&id=4dce3ebe&");
/* harmony import */ var _AccountSettings_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./AccountSettings.vue?vue&type=script&lang=js& */ "./resources/js/views/AccountSettings.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _AccountSettings_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _AccountSettings_vue_vue_type_template_id_4dce3ebe___WEBPACK_IMPORTED_MODULE_0__["render"],
  _AccountSettings_vue_vue_type_template_id_4dce3ebe___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null

)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/AccountSettings.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/AccountSettings.vue?vue&type=script&lang=js&":
/*!*************************************************************************!*\
  !*** ./resources/js/views/AccountSettings.vue?vue&type=script&lang=js& ***!
  \*************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_AccountSettings_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./AccountSettings.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/AccountSettings.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_AccountSettings_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]);

/***/ }),

/***/ "./resources/js/views/AccountSettings.vue?vue&type=template&id=4dce3ebe&":
/*!*******************************************************************************!*\
  !*** ./resources/js/views/AccountSettings.vue?vue&type=template&id=4dce3ebe& ***!
  \*******************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AccountSettings_vue_vue_type_template_id_4dce3ebe___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./AccountSettings.vue?vue&type=template&id=4dce3ebe& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/AccountSettings.vue?vue&type=template&id=4dce3ebe&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AccountSettings_vue_vue_type_template_id_4dce3ebe___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AccountSettings_vue_vue_type_template_id_4dce3ebe___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);
