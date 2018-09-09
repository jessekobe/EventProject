import { NgModule, ErrorHandler } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { IonicApp, IonicModule, IonicErrorHandler } from 'ionic-angular';
import { MyApp } from './app.component';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';

import { TabsPage } from '../pages/tabs/tabs';
import { MenuPage } from '../pages/menu/menu';
import { AuthPage } from '../pages/auth/auth';
import { LoginPage } from '../pages/login/login';
import { RegisterPage } from '../pages/register/register';
import { ForgotPage } from '../pages/forgot/forgot';
import { ControlMessages } from '../pages/login/helpers/controlMessages';
import { ValidationService } from '../pages/login/helpers/validationService';

import { HomePage } from '../pages/home/home';
import { SearchPage } from '../pages/search/search';
import { ProfilePage } from '../pages/profile/profile';
import { TestPage } from '../pages/test/test';

import { StatusBar } from '@ionic-native/status-bar';
import { SplashScreen } from '@ionic-native/splash-screen';

@NgModule({
  declarations: [
    MyApp,
    TabsPage,
    MenuPage,
    AuthPage,
    LoginPage,
    RegisterPage,
    ForgotPage,
    ControlMessages,
    HomePage,
    SearchPage,
    ProfilePage,
    TestPage,
  ],
  imports: [
    BrowserModule,
    FormsModule,
    ReactiveFormsModule,
    IonicModule.forRoot(MyApp,{
    tabsPlacement: 'top'
    })
  ],
  bootstrap: [IonicApp],
  entryComponents: [
    MyApp,
    TabsPage,
    MenuPage,
    AuthPage,
    LoginPage,
    RegisterPage,
    ForgotPage,
    ControlMessages,
    HomePage,
    SearchPage,
    ProfilePage,
    TestPage,
  ],
  providers: [
    StatusBar,
    ValidationService,
    SplashScreen,
    {provide: ErrorHandler, useClass: IonicErrorHandler}
  ]
})
export class AppModule {}
