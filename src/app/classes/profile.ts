export class Profile {
	constructor(public profileId: string,
					public profileActivationToken: string,
					public profileEmail: string,
					public profileFirstName: string,
					public profileLastName: string,
					public profilePhone: string,
	) {}
}