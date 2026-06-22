import { describe, it, expect } from 'vitest'
import { geoZones, frenchZones } from '@/stores/geoZones'

describe('geoZones (données géographiques)', () => {
  it('contient les 18 régions françaises', () => {
    expect(geoZones.regions).toHaveLength(18)
  })

  it('contient 101 départements', () => {
    expect(geoZones.departments).toHaveLength(101)
  })

  it('contient 101 codes postaux', () => {
    expect(geoZones.postalCodes).toHaveLength(101)
  })

  it('ne contient aucun département en doublon', () => {
    const unique = new Set(geoZones.departments)
    expect(unique.size).toBe(geoZones.departments.length)
  })

  it('inclut la Somme (département du siège de Webdevoo)', () => {
    expect(geoZones.departments).toContain('Somme')
    expect(geoZones.regions).toContain('Hauts-de-France')
  })
})

describe('frenchZones (cohérence régions / départements)', () => {
  it('déclare les mêmes régions que geoZones', () => {
    const regionKeys = Object.keys(frenchZones.regions)
    expect(regionKeys.sort()).toEqual([...geoZones.regions].sort())
  })

  it('associe autant de codes postaux que de départements dans chaque région', () => {
    for (const [name, zone] of Object.entries(frenchZones.regions)) {
      expect(
        zone.regionsDepartments.length,
        `Incohérence dans la région ${name}`,
      ).toBe(zone.regionsPostalsCode.length)
    }
  })

  it('référence uniquement des départements présents dans la liste globale', () => {
    const allDepartments = new Set(geoZones.departments)
    for (const zone of Object.values(frenchZones.regions)) {
      for (const dep of zone.regionsDepartments) {
        expect(allDepartments.has(dep)).toBe(true)
      }
    }
  })

  it('rattache correctement la Somme à la région Hauts-de-France', () => {
    expect(frenchZones?.regions['Hauts-de-France']?.regionsDepartments).toContain('Somme')
    expect(frenchZones?.regions['Hauts-de-France']?.regionsPostalsCode).toContain('80')
  })
})
