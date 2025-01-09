class inputMask {
	constructor(mappedMasks) {
		this.inputs = null;
		this.init();
		this.mappedMasks = mappedMasks || null;
		this.tokens = {
			'#': {
				validateRule: /\d/,
			},
			'*': {
				validateRule: /[a-zA-Z]/,
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
			input.addEventListener('keydown', this.handleBackspace.bind(this));
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

	handleBackspace(event) {
		const input = event.target;
		if (
			event.key === 'Backspace' &&
			input.selectionStart === input.selectionEnd
		) {
			const pos = input.selectionStart;
			if (pos > 0) {
				const value = input.value;
				if (!/\d/.test(value[pos - 1])) {
					event.preventDefault();
					input.value = value.slice(0, pos - 1) + value.slice(pos);
					input.setSelectionRange(pos - 1, pos - 1);
				}
			}
		}
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
			if (maskChars[i] === '#') {
				if (
					new RegExp(this.tokens['#'].validateRule).test(
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
		mask: '####-####',
		reverse: false,
		inputmode: 'tel',
	},
	'ev-tel-ddd': {
		mask: '(##) ####-####',
		reverse: false,
		inputmode: 'tel',
	},
	'ev-tel-ddd9': {
		mask: '(##) #####-####',
		reverse: false,
	},
	'ev-tel-us': {
		mask: '(###) ###-####',
		reverse: false,
		inputmode: 'tel',
	},
	'ev-cpf': {
		mask: '###.###.###-##',
		reverse: false,
		inputmode: 'numeric',
	},
	'ev-cnpj': {
		mask: '##.###.###/####-##',
		reverse: false,
		inputmode: 'numeric',
	},
	'ev-money': {
		mask: '###.###.###.###.###,##',
		reverse: true,
		inputmode: 'numeric',
	},
	'ev-ccard': {
		mask: '####-####-####-####',
		reverse: false,
		inputmode: 'numeric',
	},
	'ev-ccard-valid': {
		mask: '##/##',
		reverse: false,
		inputmode: 'numeric',
	},
	'ev-cep': {
		mask: '#####-###',
		reverse: false,
		inputmode: 'numeric',
	},
	'ev-time': {
		mask: '##:##:##',
		reverse: false,
		inputmode: 'numeric',
	},
	'ev-date': {
		mask: '##/##/####',
		reverse: false,
		inputmode: 'numeric',
	},
	'ev-date_time': {
		mask: '##/##/#### ##:##:##',
		reverse: false,
		inputmode: 'numeric',
	},
});
