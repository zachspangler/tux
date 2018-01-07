import {Injectable} from "@angular/core";
import {Status} from "../classes/status";
import {Company} from "../classes/company";
import {Observable} from "rxjs/Observable";
import {HttpClient} from "@angular/common/http";
import {Card} from "../classes/card";

@Injectable ()
export class CompanyService {

	constructor(protected http: HttpClient) {

	}

	//define the API endpoint
	private companyUrl: string = "api/company/";


	//all getBys
	getCompanyByCompanyId(id: string) : Observable<Company> {
		return(this.http.get<Company>(this.companyUrl + id));
	}

	getCompanyByCompanyCity(companyCity: string) : Observable<Company[]> {
		return(this.http.get<Company[]>(this.companyUrl + "?companyCity" + companyCity));
	}

	getCompanyByCompanyEmail(companyEmail: string) : Observable<Company> {
		return(this.http.get<Company>(this.companyUrl + "?companyEmail" + companyEmail));
	}

	getCompanyByCompanyName(companyName: string) : Observable<Company[]> {
		return(this.http.get<Company[]>(this.companyUrl + "?companyName" + companyName));
	}

	getCompanyByCompanyPhone(companyPhone: string) : Observable<Company> {
		return(this.http.get<Company>(this.companyUrl + "?companyPhone" + companyPhone));
	}

	getCompanyByCompanyPostalCode(companyPostalCode: number) : Observable<Company[]> {
		return(this.http.get<Company[]>(this.companyUrl + "?companyPostalCode" + companyPostalCode));
	}

	getCompanyByCompanyState(companyState: string) : Observable<Company[]> {
		return(this.http.get<Company[]>(this.companyUrl + "?companyState" + companyState));
	}

	getAllCompanies() : Observable<Company[]> {
		return(this.http.get<Company[]>(this.companyUrl));
	}
}