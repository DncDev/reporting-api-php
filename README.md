# AdsSquared Reporting API

The AdsSquared Reporting API allows you to retrieve various reports for your AdsSquared account.

## Installation
```
composer require ads2/reporting-api
```

## Usage
To load reports, use the Reporter facade. Provide each method with the required arguments and a report will be created and a jobID returned to the object.

Once a jobID is available, you can fetch the report with the fetchReport() method. Successfully fetched reports are available on the report's CSV property.

Available Reports:
* Device
* DeviceType
* Source
* SourceType
* DeviceHourly
* DeviceTypeHourly
* SourceHourly
* Tags


```
use AdsSquared\Facade\Reporter;

// Instantiate your report object, begin the creation of this report
$device = Reporter::Device('myUsername', 'myAPIKey', 'Jan 1, 2020', 'Jan 30, 2020', 'us', 10000);

// Retrieve the report
$device->fetchReport(); // Returns true if it retrieves the report; false otherwise

// Write the CSV report to a file
$pointer = fopen('JanReport.csv', 'w');
fputcsv($pointer, $device->csv);
fclose($pointer);

```

