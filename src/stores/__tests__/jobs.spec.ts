import { describe, it, expect } from 'vitest'
import { artisanJobs } from '@/stores/jobs'

describe('artisanJobs (liste des métiers artisanaux)', () => {
  it('est un tableau non vide de chaînes de caractères', () => {
    expect(Array.isArray(artisanJobs)).toBe(true)
    expect(artisanJobs.length).toBeGreaterThan(0)
    expect(artisanJobs.every((job) => typeof job === 'string')).toBe(true)
  })

  it('ne contient aucun doublon', () => {
    const unique = new Set(artisanJobs)
    expect(unique.size).toBe(artisanJobs.length)
  })

  it('ne contient aucune entrée vide', () => {
    expect(artisanJobs.every((job) => job.trim().length > 0)).toBe(true)
  })

  it('contient quelques métiers attendus', () => {
    expect(artisanJobs).toContain('Boulanger')
    expect(artisanJobs).toContain('Plombier')
    expect(artisanJobs).toContain('Ébéniste')
  })
})
