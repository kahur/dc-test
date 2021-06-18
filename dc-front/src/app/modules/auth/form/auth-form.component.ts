import {Component, EventEmitter, Input, Output} from "@angular/core";
import {FormControl, FormGroup, Validators} from "@angular/forms";

export interface LoginData {
  email: string;
  password: string
}
@Component({
  selector: 'dc-auth-form',
  templateUrl: './auth-form.component.html',
  styleUrls: ['./auth-form.component.css']
})
export class AuthFormComponent {
  @Output() onFormSubmit: EventEmitter<LoginData> = new EventEmitter<LoginData>();
  public form: FormGroup;
  @Input()
  public processing: boolean = false;

  constructor() {
    this.form = new FormGroup({
      email: new FormControl('', [Validators.required, Validators.email]),
      password: new FormControl('', [Validators.required, Validators.min(4)])
    });
  }

  submit(): void {
    if (this.form.valid) {
      let loginData: LoginData = this.form.getRawValue();
      this.onFormSubmit.emit(loginData);
    }
  }

  getEmailValidationError() {
    const errors = this.email?.errors;
    if (errors?.email) {
      return 'Email has wrong format';
    }

    if (errors?.required) {
      return 'Email is required';
    }

    return null;
  }

  get email() {
    return this.form.get('email');
  }

  get password() {
    return this.form.get('password');
  }
}
