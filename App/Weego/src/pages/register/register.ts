import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams } from 'ionic-angular';

import { FormBuilder, FormGroup, Validators } from "@angular/forms";
import { ValidationService } from './helpers/validationService';

import { TabsPage } from '../tabs/tabs';
import { LoginPage } from '../login/login';

/**
 * Generated class for the RegisterPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@IonicPage()
@Component({
  selector: 'page-register',
  templateUrl: 'register.html',
})
export class RegisterPage {
  userForm: any;

  constructor(public navCtrl: NavController, public navParams: NavParams, private formBuilder: FormBuilder) {
   this.userForm = this.formBuilder.group({
        'firstname': ['', [Validators.required]],
        'lastname': ['', [Validators.required]],
  		'email': ['', [Validators.required, ValidationService.emailValidator]],
  		'password': ['', [Validators.required]]
  	});
  	console.log(this.userForm);
  }

  saveUser() {
  	if(this.userForm.dirty && this.userForm.valid) {
  		alert(`Firstname: ${this.userForm.value.firstname} Lastname: ${this.userForm.value.lastname} Email: ${this.userForm.value.email} Password: ${this.userForm.value.password}`);
      var creds = {
                    firstname: this.userForm.value.firstname,
                    lastname: this.userForm.value.lastname,
                    email: this.userForm.value.email,
                    password: this.userForm.value.password
                };
      this.navCtrl.push(TabsPage);
  	}
  }

  openLogin() {
      this.navCtrl.push(LoginPage);
  }

  ionViewDidLoad() {
    console.log('ionViewDidLoad RegisterPage');
  }

}
