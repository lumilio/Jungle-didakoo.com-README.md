export function formatNumberWithSuffix(power) {
    return power >= 1000000 ? `${Math.floor(power / 1000000)}M` : ( power >= 1000 ? `${Math.floor(power / 1000)}k` : `${power}` )
}