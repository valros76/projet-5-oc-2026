import { describe, it, expect, vi, beforeEach, afterEach } from 'vitest'
import { debounce } from '@/utils/debounce'

describe('debounce', () => {
  beforeEach(() => {
    vi.useFakeTimers()
  })

  afterEach(() => {
    vi.useRealTimers()
  })

  it("n'exécute pas la fonction avant la fin du délai", () => {
    const fn = vi.fn()
    const debounced = debounce(fn, 500)

    debounced()
    expect(fn).not.toHaveBeenCalled()

    vi.advanceTimersByTime(499)
    expect(fn).not.toHaveBeenCalled()

    vi.advanceTimersByTime(1)
    expect(fn).toHaveBeenCalledTimes(1)
  })

  it("ne déclenche la fonction qu'une seule fois pour des appels rapprochés", () => {
    const fn = vi.fn()
    const debounced = debounce(fn, 300)

    debounced()
    debounced()
    debounced()
    vi.advanceTimersByTime(300)

    expect(fn).toHaveBeenCalledTimes(1)
  })

  it('réinitialise le minuteur à chaque nouvel appel', () => {
    const fn = vi.fn()
    const debounced = debounce(fn, 200)

    debounced()
    vi.advanceTimersByTime(150)
    debounced() // relance le délai
    vi.advanceTimersByTime(150)
    expect(fn).not.toHaveBeenCalled() // 150 < 200 depuis le dernier appel

    vi.advanceTimersByTime(50)
    expect(fn).toHaveBeenCalledTimes(1)
  })

  it('transmet les derniers arguments à la fonction', () => {
    const fn = vi.fn()
    const debounced = debounce(fn, 100)

    debounced('a', 1)
    debounced('b', 2)
    vi.advanceTimersByTime(100)

    expect(fn).toHaveBeenCalledWith('b', 2)
  })
})
