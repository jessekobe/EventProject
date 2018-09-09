import { Component } from '@angular/core';
import { NavController, NavParams } from 'ionic-angular';

import { RegisterPage } from '../register/register';
import { LoginPage } from '../login/login';
import { MenuPage } from '../menu/menu';

/**
 * Generated class for the AuthPage page.
 *
 * See http://ionicframework.com/docs/components/#navigation for more info
 * on Ionic pages and navigation.
 */

@Component({
  selector: 'page-auth',
  templateUrl: 'auth.html',
})
export class AuthPage {

  constructor(public navCtrl: NavController, public navParams: NavParams) {
  }

  ionViewDidLoad() {
    console.log('ionViewDidLoad AuthPage');
  }

  openLogin() {
    this.navCtrl.push(LoginPage);
  }

  openRegister() {
    this.navCtrl.push(RegisterPage);
  }

  openHome() {
    this.navCtrl.push(MenuPage);
  }

}
