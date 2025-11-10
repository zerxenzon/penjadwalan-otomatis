# Installation Checklist - SMC ICT Scalping EA v4.0

## Pre-Installation Requirements

- [ ] MetaTrader 4 or MetaTrader 5 installed
- [ ] Active trading account (demo or live)
- [ ] Minimum 500,000 IDR account balance
- [ ] XAUUSD (Gold) symbol available
- [ ] Stable internet connection

## Installation Steps

### Step 1: Download Files
- [ ] Download `SMC_ICT_Scalping_EA_v4.0.mq4` (for MT4)
- [ ] OR Download `SMC_ICT_Scalping_EA_v4.0.mq5` (for MT5)
- [ ] Save to your computer

### Step 2: Install EA

#### For MT4:
- [ ] Open MetaTrader 4
- [ ] Click File → Open Data Folder
- [ ] Navigate to MQL4 → Experts
- [ ] Copy the .mq4 file here
- [ ] Restart MT4 or click Refresh in Navigator

#### For MT5:
- [ ] Open MetaTrader 5
- [ ] Click File → Open Data Folder
- [ ] Navigate to MQL5 → Experts
- [ ] Copy the .mq5 file here
- [ ] Restart MT5 or compile in MetaEditor

### Step 3: Prepare Chart
- [ ] Open a new chart window
- [ ] Set symbol to XAUUSD (Gold)
- [ ] Set timeframe to M1 (1 minute)
- [ ] Remove other indicators/EAs if present

### Step 4: Attach EA
- [ ] Open Navigator window (Ctrl+N)
- [ ] Expand Expert Advisors
- [ ] Find SMC_ICT_Scalping_EA_v4.0
- [ ] Drag onto XAUUSD M1 chart
- [ ] Settings dialog appears

### Step 5: Configure EA

#### Required Settings (Minimum):
- [ ] Verify TradingSymbol = "XAUUSD"
- [ ] Verify Timeframe = PERIOD_M1
- [ ] Verify MagicNumber = 888888
- [ ] Check StopLossPips = 10.0
- [ ] Check EnableKillZone = true

#### Optional Settings:
- [ ] Adjust lot sizes if needed
- [ ] Modify daily targets
- [ ] Change session times if different timezone
- [ ] Set MinConfluencePoints (default: 5)

### Step 6: Enable Trading
- [ ] Click "Allow live trading" checkbox
- [ ] Click "Allow DLL imports" (not needed, but check)
- [ ] Click OK to close settings
- [ ] Enable AutoTrading button (MT4) or Algo Trading (MT5)
- [ ] Button should turn green

### Step 7: Verify Installation
- [ ] EA name shows in top-right of chart
- [ ] Smiley face is visible (not sad/crossed)
- [ ] On-chart display shows:
  ```
  === SMC ICT Scalping EA v4.0 ===
  Symbol: XAUUSD | Timeframe: M1
  [Additional information]
  ```
- [ ] No errors in Experts tab
- [ ] Status shows "Initialized"

## Post-Installation Checks

### Immediate Checks:
- [ ] EA is attached to correct chart (XAUUSD M1)
- [ ] AutoTrading/Algo Trading is enabled (green)
- [ ] Account balance displays correctly
- [ ] Kill zone status shows correctly
- [ ] No error messages

### Wait for Kill Zone:
- [ ] London session: 08:00-11:00 UTC
- [ ] NY session: 13:00-16:00 UTC
- [ ] Status should change to "Kill Zone: ACTIVE"

### First Trade:
- [ ] Wait for confluence signals
- [ ] EA will open trade automatically
- [ ] Check trade in Terminal → Trade tab
- [ ] Verify Stop Loss is set (10 pips)
- [ ] Monitor partial closures

## Troubleshooting Checklist

If EA not working:

- [ ] Check AutoTrading is enabled (green button)
- [ ] Verify chart symbol is XAUUSD
- [ ] Confirm timeframe is M1
- [ ] Check account has sufficient balance (500K+)
- [ ] Verify current time is in kill zone (if enabled)
- [ ] Look for errors in Experts tab
- [ ] Restart MetaTrader
- [ ] Reattach EA to chart

If trades not opening:

- [ ] Check kill zone status
- [ ] Verify confluence points being detected
- [ ] Check daily loss limit not reached
- [ ] Ensure no existing open position
- [ ] Review MinConfluencePoints setting (try reducing to 3)

If partial closures not working:

- [ ] Verify EA can modify trades
- [ ] Check broker allows partial closes
- [ ] Ensure minimum lot size allows splitting
- [ ] Monitor lot step requirements

## Documentation Checklist

Have you read:

- [ ] README.md - Complete feature documentation
- [ ] QUICKSTART.md - Installation and setup guide
- [ ] CONFIGURATIONS.md - Configuration templates
- [ ] CHANGELOG.md - Feature details and specifications

## Safety Checklist

Before live trading:

- [ ] Tested on demo account for 1+ week
- [ ] Understand all features and settings
- [ ] Know how to stop the EA if needed
- [ ] Have monitored at least 10+ trades
- [ ] Comfortable with risk parameters
- [ ] Reviewed and accepted disclaimer
- [ ] Starting with minimum recommended balance (500K IDR)
- [ ] Have contingency plan for losses

## Monitoring Checklist

Daily checks:

- [ ] EA is running (not stopped/crashed)
- [ ] AutoTrading still enabled
- [ ] Check daily P/L
- [ ] Review win rate
- [ ] Monitor consecutive losses
- [ ] Check for any alerts
- [ ] Verify trades executed correctly

Weekly review:

- [ ] Total trades count
- [ ] Overall win rate (target: 60%+)
- [ ] Average profit per trade
- [ ] Maximum drawdown experienced
- [ ] Settings optimization needed?
- [ ] Performance vs expectations

## Support Checklist

If you need help:

- [ ] Read documentation thoroughly first
- [ ] Check Experts tab for error messages
- [ ] Take screenshot of chart display
- [ ] Note your current settings
- [ ] Record when issue occurred
- [ ] Describe what you expected vs what happened
- [ ] Check GitHub issues for similar problems
- [ ] Create new issue with details

## Success Indicators

EA working correctly when:

✅ Status display updates every tick
✅ Kill zone detected at correct times
✅ Trades open during kill zones
✅ Stop loss set automatically
✅ Partial closures execute at TP levels
✅ Daily P/L tracked accurately
✅ Win rate calculated correctly
✅ Alerts received at targets
✅ Losing streak detection works
✅ Daily limit stops trading

## Final Verification

Before considering installation complete:

- [ ] All installation steps completed
- [ ] EA displays correctly on chart
- [ ] No errors or warnings
- [ ] Settings confirmed
- [ ] Documentation reviewed
- [ ] Ready to begin trading/testing

---

## Installation Status

Date Installed: ___________
Version: 4.0
Platform: MT4 / MT5 (circle one)
Account Type: Demo / Live (circle one)
Account Balance: ___________

## Notes

Use this space for installation notes, issues encountered, or settings used:

_____________________________________
_____________________________________
_____________________________________
_____________________________________
_____________________________________

---

**Congratulations!** 

If all items are checked, your SMC ICT Scalping EA v4.0 is properly installed and ready for trading.

Remember:
- Start with demo account
- Monitor performance closely
- Adjust settings based on results
- Trade responsibly

Happy Trading! 📈💰

---

For support: https://github.com/zerxenzon/penjadwalan-otomatis/issues
