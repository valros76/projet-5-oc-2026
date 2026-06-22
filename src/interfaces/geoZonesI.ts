export interface GeoZonesI {
  regions: string[];
  departments: string[];
  postalCodes: string[];
}

export interface DepartmentsI {
  regionsDepartments: string[];
  regionsPostalsCode: string[];
}

export interface RegionsI {
  [key: string]: DepartmentsI
}

export interface FrenchZonesI {
  regions: RegionsI;
}