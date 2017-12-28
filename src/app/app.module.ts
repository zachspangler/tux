import {NgModule} from "@angular/core";
import {BrowserModule} from "@angular/platform-browser";
import {FormsModule, ReactiveFormsModule} from "@angular/forms";
import {HttpClientModule} from "@angular/common/http";
import {AppComponent} from "./app.component";
import {allAppComponents, appRoutingProviders, routing} from "./app.routes";
import {JwtModule} from "@auth0/angular-jwt";
import {Status} from "./classes/status";
import {BrowserAnimationsModule} from "@angular/platform-browser/animations";



const moduleDeclarations = [AppComponent];

//configure the parameters fot the JwtModule
const JwtHelper = JwtModule.forRoot({
	config: {
		tokenGetter: () => {
			return localStorage.getItem("jwt-token");
		},
		skipWhenExpired:true,
		whitelistedDomains: ["localhost:7272", "https://bootcamp-coders.cnm.edu/"],
		headerName:"X-JWT-TOKEN",
		authScheme: ""
	}
});

@NgModule({
	imports:      [BrowserModule, HttpClientModule, JwtHelper,ReactiveFormsModule, FormsModule, routing, BrowserAnimationsModule],
	declarations: [...moduleDeclarations, ...allAppComponents],
	bootstrap:    [AppComponent],
	providers:    [appRoutingProviders],
	exports:      [AppComponent]
})

export class AppModule {}