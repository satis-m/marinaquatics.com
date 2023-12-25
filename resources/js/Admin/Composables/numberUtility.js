export function useNumberUtility() {
	const formattedNumber = function (number) {
		return number.toLocaleString('en-US', {
			minimumFractionDigits: 2, // Force at least two decimal places
			maximumFractionDigits: 2  // Limit to two decimal places
		})
	}

	const formattedCurrency = function (number) {
		return number.toLocaleString('en-US', {
			style: 'currency',
			currency: 'NPR'
		}).replace('NPR', 'Rs.');
	}

	return { formattedNumber , formattedCurrency};
}
