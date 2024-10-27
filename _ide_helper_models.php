<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\AboutUs
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\AboutUsTranslation|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AboutUsTranslation> $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|AboutUs listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|AboutUs newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AboutUs newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AboutUs notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|AboutUs orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|AboutUs orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|AboutUs orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|AboutUs query()
 * @method static \Illuminate\Database\Eloquent\Builder|AboutUs translated()
 * @method static \Illuminate\Database\Eloquent\Builder|AboutUs translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|AboutUs whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AboutUs whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AboutUs whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|AboutUs whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|AboutUs whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AboutUs withTranslation()
 */
	class AboutUs extends \Eloquent implements \Astrotomic\Translatable\Contracts\Translatable {}
}

namespace App\Models{
/**
 * App\Models\AboutUsTranslation
 *
 * @property int $id
 * @property int $about_us_id
 * @property string $locale
 * @property string|null $description
 * @method static \Illuminate\Database\Eloquent\Builder|AboutUsTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AboutUsTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AboutUsTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|AboutUsTranslation whereAboutUsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AboutUsTranslation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AboutUsTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AboutUsTranslation whereLocale($value)
 */
	class AboutUsTranslation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\City
 *
 * @property int $id
 * @property int|null $status
 * @property int $country_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Client> $clients
 * @property-read int|null $clients_count
 * @property-read \App\Models\Country $country
 * @property-read \App\Models\CityTranslation|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CityTranslation> $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|City listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|City orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|City orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|City orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|City query()
 * @method static \Illuminate\Database\Eloquent\Builder|City translated()
 * @method static \Illuminate\Database\Eloquent\Builder|City translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|City whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City withTranslation()
 */
	class City extends \Eloquent implements \Astrotomic\Translatable\Contracts\Translatable {}
}

namespace App\Models{
/**
 * App\Models\CityTranslation
 *
 * @property int $id
 * @property int $city_id
 * @property string $locale
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|CityTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CityTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CityTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|CityTranslation whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CityTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CityTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CityTranslation whereName($value)
 */
	class CityTranslation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Client
 *
 * @property int $id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $country_code
 * @property string|null $phone
 * @property string|null $work_mobile
 * @property string|null $home_mobile
 * @property string|null $linkedin_id
 * @property string|null $apple_id
 * @property string|null $website
 * @property string|null $email
 * @property string|null $company_name
 * @property string|null $image
 * @property float|null $lat
 * @property float|null $lng
 * @property string|null $fcm_token
 * @property int|null $mobile_id 0 => android , 1 => ios
 * @property string|null $forget_code
 * @property int $status -1 => blocked or deleted , 0 => not active , 1 => active
 * @property int $share_data 0 => private , 1 => public
 * @property string|null $street_name
 * @property string|null $building_no
 * @property string|null $office_no
 * @property string|null $other_details
 * @property string|null $office_phone
 * @property string|null $office_fax
 * @property string|null $p_o_pox
 * @property string|null $zip_code
 * @property string|null $details
 * @property string|null $lang
 * @property string|null $otp_code
 * @property string|null $qr_code
 * @property string|null $qr_code_user
 * @property int|null $country_id
 * @property int|null $city_id
 * @property int|null $job_title_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $linkedin
 * @property string|null $twitter
 * @property string|null $instagram
 * @property string|null $facebook
 * @property string|null $office_country_code
 * @property-read \App\Models\City|null $city
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Client> $clients
 * @property-read int|null $clients_count
 * @property-read \App\Models\Country|null $country
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Client> $friends
 * @property-read int|null $friends_count
 * @property-read mixed $image_path
 * @property-read \App\Models\JobTitle|null $jobTitle
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Journey> $journeys
 * @property-read int|null $journeys_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ClientPhone> $phones
 * @property-read int|null $phones_count
 * @method static \Database\Factories\ClientFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Client newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Client newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Client query()
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereAppleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereBuildingNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereFacebook($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereFcmToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereForgetCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereHomeMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereInstagram($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereJobTitleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereLinkedin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereLinkedinId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereMobileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereOfficeCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereOfficeFax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereOfficeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereOfficePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereOtherDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereOtpCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client wherePOPox($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereQrCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereQrCodeUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereShareData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereStreetName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereTwitter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereWebsite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereWorkMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereZipCode($value)
 */
	class Client extends \Eloquent implements \Tymon\JWTAuth\Contracts\JWTSubject {}
}

namespace App\Models{
/**
 * App\Models\ClientFriend
 *
 * @property int $id
 * @property int|null $accepted
 * @property int|null $client_id
 * @property int|null $friend_id
 * @property int $share_data 0 => private , 1 => public
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ClientFriend newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientFriend newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientFriend query()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientFriend whereAccepted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientFriend whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientFriend whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientFriend whereFriendId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientFriend whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientFriend whereShareData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientFriend whereUpdatedAt($value)
 */
	class ClientFriend extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ClientJourney
 *
 * @property int $id
 * @property int|null $client_id
 * @property int|null $journey_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ClientJourney newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientJourney newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientJourney query()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientJourney whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientJourney whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientJourney whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientJourney whereJourneyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientJourney whereUpdatedAt($value)
 */
	class ClientJourney extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ClientPhone
 *
 * @property int $id
 * @property string|null $country_code
 * @property string|null $phone
 * @property int|null $client_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ClientPhone newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientPhone newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientPhone query()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientPhone whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientPhone whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientPhone whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientPhone whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientPhone wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientPhone whereUpdatedAt($value)
 */
	class ClientPhone extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Country
 *
 * @property int $id
 * @property int|null $status
 * @property string|null $alpha3
 * @property string|null $alpha2
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\CountryTranslation|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CountryTranslation> $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|Country listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|Country newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Country newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Country notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Country orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Country orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Country orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Country query()
 * @method static \Illuminate\Database\Eloquent\Builder|Country translated()
 * @method static \Illuminate\Database\Eloquent\Builder|Country translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereAlpha2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereAlpha3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country withTranslation()
 */
	class Country extends \Eloquent implements \Astrotomic\Translatable\Contracts\Translatable {}
}

namespace App\Models{
/**
 * App\Models\CountryTranslation
 *
 * @property int $id
 * @property string $locale
 * @property string $name
 * @property int $country_id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CountryTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CountryTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CountryTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|CountryTranslation whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CountryTranslation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CountryTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CountryTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CountryTranslation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CountryTranslation whereUpdatedAt($value)
 */
	class CountryTranslation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\JobTitle
 *
 * @property int $id
 * @property int|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\JobTitleTranslation|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\JobTitleTranslation> $translations
 * @property-read int|null $translations_count
 * @method static \Database\Factories\JobTitleFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|JobTitle listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|JobTitle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JobTitle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JobTitle notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|JobTitle orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|JobTitle orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|JobTitle orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|JobTitle query()
 * @method static \Illuminate\Database\Eloquent\Builder|JobTitle translated()
 * @method static \Illuminate\Database\Eloquent\Builder|JobTitle translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|JobTitle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobTitle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobTitle whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobTitle whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|JobTitle whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|JobTitle whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobTitle withTranslation()
 */
	class JobTitle extends \Eloquent implements \Astrotomic\Translatable\Contracts\Translatable {}
}

namespace App\Models{
/**
 * App\Models\JobTitleTranslation
 *
 * @property int $id
 * @property int $job_title_id
 * @property string $locale
 * @property string $name
 * @method static \Database\Factories\JobTitleTranslationFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|JobTitleTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JobTitleTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JobTitleTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|JobTitleTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobTitleTranslation whereJobTitleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobTitleTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobTitleTranslation whereName($value)
 */
	class JobTitleTranslation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Journey
 *
 * @property int $id
 * @property string|null $name
 * @property float|null $lat
 * @property float|null $lng
 * @property string|null $date
 * @property string|null $address
 * @property int|null $client_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Client> $clients
 * @property-read int|null $clients_count
 * @method static \Illuminate\Database\Eloquent\Builder|Journey newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Journey newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Journey query()
 * @method static \Illuminate\Database\Eloquent\Builder|Journey whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Journey whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Journey whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Journey whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Journey whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Journey whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Journey whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Journey whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Journey whereUpdatedAt($value)
 */
	class Journey extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MaximumNumberOfMessage
 *
 * @property int $id
 * @property string|null $ip_address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|MaximumNumberOfMessage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MaximumNumberOfMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MaximumNumberOfMessage query()
 * @method static \Illuminate\Database\Eloquent\Builder|MaximumNumberOfMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaximumNumberOfMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaximumNumberOfMessage whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaximumNumberOfMessage whereUpdatedAt($value)
 */
	class MaximumNumberOfMessage extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Note
 *
 * @property int $id
 * @property int|null $client_id
 * @property int|null $friend_id
 * @property string|null $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Note newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Note newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Note query()
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereFriendId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereUpdatedAt($value)
 */
	class Note extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Permission
 *
 * @property int $id
 * @property string $name
 * @property string|null $display_name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereUpdatedAt($value)
 */
	class Permission extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Role
 *
 * @property int $id
 * @property string $name
 * @property string|null $display_name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SentNotification
 *
 * @property int $id
 * @property int|null $client_id
 * @property string|null $title_ar
 * @property string|null $title_en
 * @property string|null $body_ar
 * @property string|null $body_en
 * @property string|null $qr_code
 * @property string|null $share_data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SentNotification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SentNotification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SentNotification query()
 * @method static \Illuminate\Database\Eloquent\Builder|SentNotification whereBodyAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SentNotification whereBodyEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SentNotification whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SentNotification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SentNotification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SentNotification whereQrCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SentNotification whereShareData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SentNotification whereTitleAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SentNotification whereTitleEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SentNotification whereUpdatedAt($value)
 */
	class SentNotification extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Setting
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\SettingTranslation|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SettingTranslation> $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|Setting listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting translated()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting withTranslation()
 */
	class Setting extends \Eloquent implements \Astrotomic\Translatable\Contracts\Translatable {}
}

namespace App\Models{
/**
 * App\Models\SettingTranslation
 *
 * @property int $id
 * @property int $setting_id
 * @property string $locale
 * @property string $terms_and_conditions
 * @property string $privacy_policy
 * @method static \Illuminate\Database\Eloquent\Builder|SettingTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SettingTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SettingTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|SettingTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SettingTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SettingTranslation wherePrivacyPolicy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SettingTranslation whereSettingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SettingTranslation whereTermsAndConditions($value)
 */
	class SettingTranslation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property string|null $address
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $image
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $image_path
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User orWherePermissionIs($permission = '')
 * @method static \Illuminate\Database\Eloquent\Builder|User orWhereRoleIs($role = '', $team = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDoesntHavePermission()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDoesntHaveRole()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePermissionIs($permission = '', $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRoleIs($role = '', $team = null, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\VoiceNote
 *
 * @property int $id
 * @property int|null $client_id
 * @property int|null $friend_id
 * @property string|null $voice_note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|VoiceNote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VoiceNote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VoiceNote query()
 * @method static \Illuminate\Database\Eloquent\Builder|VoiceNote whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VoiceNote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VoiceNote whereFriendId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VoiceNote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VoiceNote whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VoiceNote whereVoiceNote($value)
 */
	class VoiceNote extends \Eloquent {}
}

