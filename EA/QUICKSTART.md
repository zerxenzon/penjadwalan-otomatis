# SMC ICT Scalping EA v4.0 - Quick Start Guide

## Installation Steps

### Step 1: Download Files
Download the following files from the EA directory:
- `SMC_ICT_Scalping_EA_v4.0.mq4` (for MetaTrader 4)
- `SMC_ICT_Scalping_EA_v4.0.mq5` (for MetaTrader 5)

### Step 2: Install in MetaTrader

#### For MetaTrader 4:
1. Open MetaTrader 4
2. Click **File → Open Data Folder**
3. Navigate to **MQL4 → Experts**
4. Copy `SMC_ICT_Scalping_EA_v4.0.mq4` into this folder
5. Close and reopen MetaTrader 4 (or click Refresh in Navigator)

#### For MetaTrader 5:
1. Open MetaTrader 5
2. Click **File → Open Data Folder**
3. Navigate to **MQL5 → Experts**
4. Copy `SMC_ICT_Scalping_EA_v4.0.mq5` into this folder
5. Close and reopen MetaTrader 5 (or compile in MetaEditor)

### Step 3: Setup Chart
1. Open a new chart
2. Set the symbol to **XAUUSD** (Gold)
3. Set the timeframe to **M1** (1 Minute)
4. Right-click chart → **Template → Save Template** (optional, for quick access)

### Step 4: Attach EA to Chart
1. In Navigator window, expand **Expert Advisors**
2. Find **SMC_ICT_Scalping_EA_v4.0**
3. Drag it onto the XAUUSD M1 chart
4. A settings window will appear

### Step 5: Configure Settings

#### Minimum Required Settings:
```
=== PHASE 1: RISK MANAGEMENT ===
StopLossPips: 10.0
MaxLossPerTrade: 100000
DailyLossLimit: 200000
MinLotSize: 0.01
MaxLotSize: 0.10

=== PHASE 2: PROFIT OPTIMIZATION ===
EnableKillZone: true
MinConfluencePoints: 5

=== TECHNICAL SPECIFICATIONS ===
TradingSymbol: XAUUSD
MagicNumber: 888888
```

Keep all other settings at default values initially.

### Step 6: Enable AutoTrading
- **MT4**: Click the **AutoTrading** button in toolbar (or press F7)
- **MT5**: Click the **Algo Trading** button in toolbar

### Step 7: Verify Operation
You should see on the chart:
```
=== SMC ICT Scalping EA v4.0 ===
Symbol: XAUUSD | Timeframe: M1
Account: [Your Balance] IDR
-----------------------------------
[Statistics and status information]
```

## First Trade Checklist

✓ **Before First Trade:**
- [ ] EA is attached to XAUUSD M1 chart
- [ ] AutoTrading/Algo Trading is enabled (green button)
- [ ] Account balance is at least 500,000 IDR
- [ ] Current time is within kill zone (London 08:00-11:00 or NY 13:00-16:00 UTC)
- [ ] EA displays "Kill Zone: ACTIVE" status
- [ ] No error messages in the Experts tab

✓ **After First Trade:**
- [ ] Check the trade opened correctly in Terminal → Trade tab
- [ ] Verify Stop Loss is set at 10 pips from entry
- [ ] Observe the on-chart display updates
- [ ] Monitor partial closures at TP1, TP2, TP3, TP4

## Common Issues & Solutions

### Issue 1: EA shows "Outside Kill Zone"
**Solution:** Trading is restricted to London (08:00-11:00 UTC) and NY (13:00-16:00 UTC) sessions. Either:
- Wait for the kill zone time
- Disable kill zone by setting `EnableKillZone = false`

### Issue 2: EA not opening trades
**Possible Causes:**
1. **Not enough confluence points** - EA requires minimum 5 confluence signals by default
   - Solution: Reduce `MinConfluencePoints` to 3-4
2. **Daily loss limit reached** - EA stops trading after reaching daily limit
   - Solution: Wait for next trading day or increase `DailyLossLimit`
3. **Already has open position** - EA only opens one trade at a time
   - Solution: Wait for current trade to close

### Issue 3: Lot size too small/large
**Solution:** Adjust these parameters:
```
MinLotSize: [your preferred min]
MaxLotSize: [your preferred max]
LondonLotSize: [lot for London session]
NYLotSize: [lot for NY session]
```

### Issue 4: "Invalid stops" error
**Solution:** Your broker may have minimum stop loss distance. Check broker requirements:
1. Open Market Watch
2. Right-click XAUUSD → Specification
3. Check "Stops level"
4. Adjust `StopLossPips` to be higher than stops level

### Issue 5: EA immediately disabled
**Possible Causes:**
1. **DLL imports not allowed** - Not applicable to this EA
2. **AutoTrading not enabled** - Click the AutoTrading button
3. **EA trading not allowed in settings** - Tools → Options → Expert Advisors → Enable

## Optimization for Your Account

### For Conservative Trading:
```
MaxLossPerTrade: 50000      // Reduce risk per trade
DailyLossLimit: 100000      // Reduce daily risk
MaxLotSize: 0.05            // Limit max position size
MinConfluencePoints: 6      // Require more signals
EnableKillZone: true        // Trade only best hours
```

### For Aggressive Trading:
```
MaxLossPerTrade: 150000     // Increase risk per trade
DailyLossLimit: 300000      // Allow more daily trades
MaxLotSize: 0.15            // Allow larger positions
MinConfluencePoints: 4      // Trade more opportunities
EnableKillZone: true        // Still respect kill zones
```

### For Maximum Trades:
```
MinConfluencePoints: 3      // Lower entry requirement
EnableKillZone: false       // Trade all hours
OffPeakLotSize: 0.03        // Increase off-peak lot
```

## Monitoring Performance

### Daily Checklist:
1. **Morning** (before London open):
   - Check yesterday's results
   - Verify account balance
   - Ensure EA is running

2. **During Trading**:
   - Monitor on-chart display
   - Check for alerts
   - Review partial closures

3. **Evening** (after NY close):
   - Review total trades
   - Check win rate
   - Evaluate daily P/L

### Weekly Review:
- Total trades for the week
- Overall win rate (target: >60%)
- Average profit per trade
- Maximum drawdown
- Adjust settings if needed

## Performance Targets

### Expected Performance (500K IDR account):
- **Daily Target**: 500,000 IDR (100% of account)
- **Weekly Target**: 2,000,000 - 3,000,000 IDR
- **Monthly Target**: 10,000,000 - 15,000,000 IDR

### Risk Metrics:
- **Max Daily Loss**: 200,000 IDR (40% of account)
- **Max Loss Per Trade**: 100,000 IDR (20% of account)
- **Win Rate Target**: >60%
- **Risk:Reward Ratio**: 1:2 minimum

## Advanced Settings

### Session-Based Optimization:
```
London Session (08:00-11:00 UTC):
- High volatility
- Best for scalping
- Use LondonLotSize = 0.05

NY Session (13:00-16:00 UTC):
- Highest volume
- Strong trends
- Use NYLotSize = 0.05

Overlap (13:00-14:00 UTC):
- Maximum liquidity
- Best trading window
- Consider increasing lot size
```

### Win Rate Adjustment:
The EA automatically adjusts lot sizes based on performance:
```
Win Rate > 75%: Lot = 0.06 (increase)
Win Rate 60-75%: Lot = 0.05 (maintain)
Win Rate < 60%: Lot = 0.03 (decrease)
```

Monitor this behavior and adjust thresholds if needed.

## Getting Help

### Check Logs:
1. Open **Experts** tab in Terminal window
2. Look for messages from "SMC_ICT_Scalping_EA_v4.0"
3. Copy relevant error messages

### Enable Detailed Logging:
1. Tools → Options → Expert Advisors
2. Enable "Journal" tab
3. Restart EA

### Report Issues:
Include the following information:
- MT4 or MT5 version
- Account balance and currency
- Current settings (screenshot)
- Error messages from Experts tab
- Time of issue occurrence

## Safety Reminders

⚠️ **IMPORTANT:**
1. **Start with demo account** - Test for at least 1 week
2. **Never risk more than you can afford to lose**
3. **Keep daily loss limit reasonable** (40% of account max)
4. **Monitor the EA regularly** - It's automated, not autonomous
5. **Adjust settings based on performance** - One size doesn't fit all
6. **Use VPS for 24/7 operation** - Avoid missed opportunities
7. **Keep account funded** - Maintain minimum 500K IDR balance
8. **Review trades daily** - Learn from wins and losses

## Support Resources

- **Documentation**: See `README.md` in EA directory
- **Settings Guide**: See main README for detailed parameter explanations
- **Issue Tracker**: https://github.com/zerxenzon/penjadwalan-otomatis/issues

---

**Ready to Start Trading!**

Once you've completed all steps and verified the EA is working correctly, you're ready to let it trade. Remember to:
- Monitor performance daily
- Adjust settings based on results
- Keep learning from each trade
- Stay disciplined with risk management

Good luck and happy trading! 📈💰
