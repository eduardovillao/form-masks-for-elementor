class inputMask {
	constructor(mappedMasks) {
		this.inputs = null;
		this.init();
		this.mappedMasks = mappedMasks || null;
		this.tokens = {
			'0': {
				validateRule: /\d/,
			},
		};
	}

	init() {
		if (document.readyState !== 'complete') {
			window.addEventListener('load', this.init.bind(this));
			return;
		}

		this.initModalListener();
		this.getInput();
	}

	initModalListener() {
		const body = document.body;

		const observer = new MutationObserver((mutations) => {
			mutations.forEach((mutation) => {
				if (mutation.type === 'childList') {
					mutation.addedNodes.forEach((node) => {
						if (
							node.classList &&
							node.classList.contains('elementor-popup-modal')
						) {
							this.getInput();
						}
					});
				}
			});
		});

		observer.observe(body, { childList: true });
	}

	getInput() {
		this.inputs = document.querySelectorAll('input[data-mask]');
		this.inputs.forEach((input) => {
			this.handleMappedMasks(input);
			input.addEventListener('input', this.maskInput.bind(this));
		});
	}

	handleMappedMasks(input) {
		if (!this.mappedMasks) {
			return;
		}

		const replaceMaks = this.mappedMasks[input.dataset.mask];
		if (!replaceMaks) {
			return;
		}

		input.dataset.mask = replaceMaks.mask;
		input.dataset.maskReverse = replaceMaks.reverse;
		input.inputmode = replaceMaks.inputmode;
	}

	maskInput(event) {
		if (event.inputType === 'deleteContentBackward') {
			return;
		}

		const input = event.target;
		const mask = input.dataset.mask;
		const value = input.value;
		const unmaskedValue = this.removeMask(mask, value);
		const isReverse = input.dataset.maskReverse === 'true';
		const maskedValue = this.applyMask(unmaskedValue, mask, isReverse);

		input.value = maskedValue;
	}

	removeMask(mask, value) {
		if (!mask || !value) {
			return value;
		}

		const allowTokens = Object.keys(this.tokens);
		const allowTokensRegex = new RegExp(`[${allowTokens.join('')}]`, 'g');
		const maskLiteralsToRemove = mask.replace(allowTokensRegex, '');
		return value.replace(new RegExp(`[${maskLiteralsToRemove}]`, 'g'), '');
	}

	applyMask(unmaskedValue, mask, isReverse) {
		if (!unmaskedValue) {
			return unmaskedValue;
		}

		let maskedValue = '';
		let valueIndex = 0;
		let maskChars = mask.split('');

		if (isReverse) {
			unmaskedValue = unmaskedValue.split('').reverse().join('');
			maskChars = maskChars.reverse();
		}

		for (let i = 0; i < maskChars.length; i++) {
			if (maskChars[i] === '0') {
				if (
					new RegExp(this.tokens['0'].validateRule).test(
						unmaskedValue[valueIndex]
					)
				) {
					maskedValue += unmaskedValue[valueIndex];
					valueIndex++;
				} else {
					break;
				}
			} else {
				maskedValue += maskChars[i];
			}
		}

		if (isReverse) {
			maskedValue = maskedValue.split('').reverse().join('');
			maskedValue = maskedValue.startsWith('.')
				? maskedValue.substring(1)
				: maskedValue;
		}

		return maskedValue;
	}
}

new inputMask({
	'ev-tel': {
		mask: '0000-0000',
		reverse: false,
		inputmode: 'tel',
	},
	'ev-tel-ddd': {
		mask: '(00) 0000-0000',
		reverse: false,
		inputmode: 'tel',
	},
	'ev-tel-ddd9': {
		mask: '(00) 00000-0000',
		reverse: false,
	},
	'ev-tel-us': {
		mask: '(000) 000-0000',
		reverse: false,
		inputmode: 'tel',
	},
	'ev-cpf': {
		mask: '000.000.000-00',
		reverse: false,
		inputmode: 'numeric',
	},
	'ev-cnpj': {
		mask: '00.000.000/0000-00',
		reverse: false,
		inputmode: 'numeric',
	},
	'ev-money': {
		mask: '000.000.000.000.000,00',
		reverse: true,
		inputmode: 'numeric',
	},
	'ev-ccard': {
		mask: '0000-0000-0000-0000',
		reverse: false,
		inputmode: 'numeric',
	},
	'ev-ccard-valid': {
		mask: '00/00',
		reverse: false,
		inputmode: 'numeric',
	},
	'ev-cep': {
		mask: '00000-000',
		reverse: false,
		inputmode: 'numeric',
	},
	'ev-time': {
		mask: '00:00:00',
		reverse: false,
		inputmode: 'numeric',
	},
	'ev-date': {
		mask: '00/00/0000',
		reverse: false,
		inputmode: 'numeric',
	},
	'ev-date_time': {
		mask: '00/00/0000 00:00:00',
		reverse: false,
		inputmode: 'numeric',
	},
});
