import { Component, Input } from '@angular/core';
import { FormControl } from '@angular/forms';
import { ValidationService } from './validationService';

@Component({
	selector: 'control-messages',
	template: `<div style="margin-left: 15px;" *ngIf="errorMessage !== null"><ion-icon name="alert"></ion-icon> {{errorMessage}}</div>`	    
})

export class ControlMessages {
	@Input() control: FormControl;
	
	constructor() {
		// code...
	}

	get errorMessage() {
		for (let propertyName in this.control.errors) {
			if(this.control.errors.hasOwnProperty(propertyName) && this.control.touched) {
				return ValidationService.getValidatorErrorMessage(propertyName, this.control.errors[propertyName])
			}
		}
		return null;
	}
}