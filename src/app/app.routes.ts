//import needed @angularDependencies
import {RouterModule, Routes} from "@angular/router";
import {AuthGuardService as AuthGuard} from "./services/auth.guard.service";

//import all needed Interceptors
import {APP_BASE_HREF} from "@angular/common";
import {HTTP_INTERCEPTORS} from "@angular/common/http";
import {DeepDiveInterceptor} from "./services/deep.dive.interceptor";

// import all components
import {SplashComponent} from "./components/splash.component";
import {LandingPageComponent} from "./components/landing.page.component";
import {HomeComponent} from "./components/home.component";
import {CompanyComponent} from "./components/company.component";
import {SignInComponent} from "./components/sign.in.component";
import {SignUpComponent} from "./components/sign.up.component";
import {SignOutComponent} from "./components/sign.out.component";
import {NavigationTopComponent} from "./components/navigation-top.component";
import {CreateWeddingComponent} from "./components/create.wedding.component";

// import services
import {AuthService} from "./services/auth.service";
import {AuthGuardService} from "./services/auth.guard.service";
import {CookieService} from "ng2-cookies";
import {JwtHelperService} from "@auth0/angular-jwt";
import {SessionService} from "./services/session.service";
import {WeddingService} from "./services/wedding.service";
import {SignInService} from "./services/sign.in.service";
import {SignUpService} from "./services/sign.up.service";
import {SignOutService} from "./services/sign.out.service";



//an array of the components that will be passed off to the module
export const allAppComponents = [
	SplashComponent,
	LandingPageComponent,
	HomeComponent,
	NavigationTopComponent,
	CreateWeddingComponent,
	CompanyComponent,
	SignInComponent,
	SignUpComponent,
	SignOutComponent,
];

//an array of routes that will be passed of to the module
export const routes: Routes = [
	{path: "", component: LandingPageComponent},
	{path: "home", component: HomeComponent},
	{path: "company", component: CompanyComponent},
	{path: "sign-out", component: SignOutComponent},
];

// an array of services that will be passed off to the module
const services : any[] = [AuthService, CookieService, JwtHelperService, SessionService, WeddingService, SignInService, SignUpService, SignOutService, AuthGuardService];

// an array of misc providers
export const providers: any[] = [
	{provide: APP_BASE_HREF, useValue: window["_base_href"]},
	{provide: HTTP_INTERCEPTORS, useClass: DeepDiveInterceptor, multi: true},
];

export const appRoutingProviders: any[] = [providers, services];

export const routing = RouterModule.forRoot(routes);