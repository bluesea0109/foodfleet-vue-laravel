import { description } from '../composer.json'
import { create } from '@storybook/theming'

export default create({
  base: 'light',
  brandTitle: description || 'Fresh Platform UI StyleGuide'
})
