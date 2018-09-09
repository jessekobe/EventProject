import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams } from 'ionic-angular';

import { FormBuilder, FormGroup, Validators } from "@angular/forms";
import { ValidationService } from './helpers/validationService';

import { TabsPage } from '../tabs/tabs';
import { RegisterPage } from '../register/register';
import { ForgotPage } from '../forgot/forgot';

/**
 * Generated class for the LoginPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@IonicPage()
@Component({
  selector: 'page-login',
  templateUrl: 'login.html',
})
export class LoginPage {
  userForm: any;

  constructor(public navCtrl: NavController, public navParams: NavParams, private formBuilder: FormBuilder) {
   this.userForm = this.formBuilder.group({
  		'email': ['', [Validators.required, ValidationService.emailValidator]],
  		'password': ['', [Validators.required]]
  	});
  	console.log(this.userForm);
  }

  saveUser() {
  	if(this.userForm.dirty && this.userForm.valid) {
  		alert(`Email: ${this.userForm.value.email} Password: ${this.userForm.value.password}`);
      var creds = {
                    username: this.userForm.value.email,
                    password: this.userForm.value.password
                };
      this.navCtrl.push(TabsPage);
  	}
  }

  openRegister() {
      this.navCtrl.push(RegisterPage);
  }

  openForgot() {
      this.navCtrl.push(ForgotPage);
  }

  ionViewDidLoad() {
    console.log('ionViewDidLoad LoginPage');
  }

}
