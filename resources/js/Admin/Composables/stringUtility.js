import _ from 'lodash';

export function useStringUtility() {
	const wordToCamel = function (str) {
		return str.replace(/\W+(.)/g, function (match, chr) {
			return chr.toUpperCase();
		});
	}
	const camelToWord = function (key) {
		return _.startCase(key);
	}
	const readableWord = function (key) {
		return _.startCase(key);
	}
    const wordInitials = function (str) {
        const words = str.split(' ');
        const initials = words.map(word => word.charAt(0).toUpperCase());
        return initials.join('');
    }
    const removeHTMLTags = (html) => {
        const doc = new DOMParser().parseFromString(html, 'text/html');
        return doc.body.textContent || "";
    }

	return { wordToCamel, camelToWord, readableWord,wordInitials,removeHTMLTags };
}
