import { createI18n } from 'vue-i18n';
import messages from './messages';

export const i18n = createI18n({
    legacy: false,
    locale: 'pt_BR',
    fallbackLocale: 'en',
    messages,
    warnHtmlInMessage: 'off',
    silentTranslationWarn: true,
    silentFallbackWarn: true,
    allowComposition: true,
    useScope: 'global',
    globalInjection: true,
    missingWarn: false,
    fallbackWarn: false
});
