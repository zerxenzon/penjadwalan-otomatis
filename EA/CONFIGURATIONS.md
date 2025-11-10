# SMC ICT Scalping EA v4.0 - Configuration Templates

## Default Configuration (500K IDR Account)

### Risk Management (PHASE 1)
```
StopLossPips = 10.0
MaxLossPerTrade = 100000
DailyLossLimit = 200000
MinLotSize = 0.01
MaxLotSize = 0.10
```

### Profit Optimization (PHASE 2)
```
TP1_Pips = 5.0
TP1_Percent = 20.0
TP2_Pips = 10.0
TP2_Percent = 30.0
TP3_Pips = 15.0
TP3_Percent = 30.0
TP4_Pips = 20.0
TP4_Percent = 20.0

EnableKillZone = true
LondonStartHour = 8
LondonEndHour = 11
NYStartHour = 13
NYEndHour = 16

LondonLotSize = 0.05
NYLotSize = 0.05
OffPeakLotSize = 0.01

MinConfluencePoints = 5
```

### Auto-Adjustment (PHASE 3)
```
WinRateTrackingPeriod = 20
HighWinRateThreshold = 75.0
MediumWinRateThreshold = 60.0
HighWinRateLot = 0.06
MediumWinRateLot = 0.05
LowWinRateLot = 0.03

LosingStreakThreshold = 3
DailyTarget1 = 300000
DailyTarget2 = 400000
DailyTarget3 = 500000
```

### Technical Specifications
```
TradingSymbol = XAUUSD
Timeframe = PERIOD_M1
MagicNumber = 888888
Slippage = 3
```

### SMC/ICT Parameters
```
EnableOrderBlocks = true
EnableFVG = true
EnableBOS = true
EnableCHoCH = true
EnableLiquiditySweep = true

OrderBlockLookback = 50
FVGLookback = 30
SwingLookback = 20
LiquiditySwipeDistance = 5.0
```

---

## Conservative Configuration (Low Risk)

### Risk Management
```
StopLossPips = 10.0
MaxLossPerTrade = 50000          // Reduced to 50K
DailyLossLimit = 100000          // Reduced to 100K
MinLotSize = 0.01
MaxLotSize = 0.05                // Limited to 0.05
```

### Profit Optimization
```
TP1_Pips = 5.0
TP1_Percent = 30.0               // Take more profit early
TP2_Pips = 10.0
TP2_Percent = 40.0               // Take more profit early
TP3_Pips = 15.0
TP3_Percent = 20.0
TP4_Pips = 20.0
TP4_Percent = 10.0

EnableKillZone = true
LondonLotSize = 0.03             // Reduced lot size
NYLotSize = 0.03
OffPeakLotSize = 0.01

MinConfluencePoints = 6          // Require more signals
```

### Auto-Adjustment
```
HighWinRateLot = 0.04
MediumWinRateLot = 0.03
LowWinRateLot = 0.02

DailyTarget1 = 150000            // Lower targets
DailyTarget2 = 200000
DailyTarget3 = 250000
```

---

## Aggressive Configuration (High Risk/Reward)

### Risk Management
```
StopLossPips = 10.0
MaxLossPerTrade = 150000         // Increased to 150K
DailyLossLimit = 300000          // Increased to 300K
MinLotSize = 0.02
MaxLotSize = 0.15                // Increased to 0.15
```

### Profit Optimization
```
TP1_Pips = 5.0
TP1_Percent = 15.0               // Let more run
TP2_Pips = 10.0
TP2_Percent = 25.0
TP3_Pips = 15.0
TP3_Percent = 30.0
TP4_Pips = 20.0
TP4_Percent = 30.0

EnableKillZone = true
LondonLotSize = 0.08             // Increased lot size
NYLotSize = 0.08
OffPeakLotSize = 0.02

MinConfluencePoints = 4          // Lower requirement
```

### Auto-Adjustment
```
HighWinRateLot = 0.10
MediumWinRateLot = 0.08
LowWinRateLot = 0.05

DailyTarget1 = 400000            // Higher targets
DailyTarget2 = 600000
DailyTarget3 = 800000
```

---

## Scalping Focus Configuration (Quick Profits)

### Risk Management
```
StopLossPips = 8.0               // Tighter stop
MaxLossPerTrade = 80000
DailyLossLimit = 200000
MinLotSize = 0.01
MaxLotSize = 0.10
```

### Profit Optimization
```
TP1_Pips = 3.0                   // Faster TP1
TP1_Percent = 40.0               // Take more profit
TP2_Pips = 5.0                   // Faster TP2
TP2_Percent = 30.0
TP3_Pips = 8.0                   // Faster TP3
TP3_Percent = 20.0
TP4_Pips = 12.0                  // Faster TP4
TP4_Percent = 10.0

EnableKillZone = true            // Only trade kill zones
LondonLotSize = 0.05
NYLotSize = 0.05
OffPeakLotSize = 0.01

MinConfluencePoints = 5
```

### SMC/ICT (Focus on quick signals)
```
EnableOrderBlocks = true
EnableFVG = true
EnableBOS = true
EnableCHoCH = false              // Disable slower signals
EnableLiquiditySweep = true

OrderBlockLookback = 30          // Shorter lookback
FVGLookback = 20
SwingLookback = 15
```

---

## Trend Following Configuration

### Risk Management
```
StopLossPips = 10.0
MaxLossPerTrade = 100000
DailyLossLimit = 200000
MinLotSize = 0.01
MaxLotSize = 0.10
```

### Profit Optimization
```
TP1_Pips = 8.0                   // Let it run more
TP1_Percent = 15.0
TP2_Pips = 15.0
TP2_Percent = 20.0
TP3_Pips = 25.0
TP3_Percent = 30.0
TP4_Pips = 35.0
TP4_Percent = 35.0

EnableKillZone = true
MinConfluencePoints = 5
```

### SMC/ICT (Focus on structure)
```
EnableOrderBlocks = true
EnableFVG = true
EnableBOS = true                 // Key for trends
EnableCHoCH = true               // Key for trends
EnableLiquiditySweep = true

OrderBlockLookback = 50
SwingLookback = 30               // Longer lookback
```

---

## 24/7 Trading Configuration (Use with VPS)

### Risk Management
```
StopLossPips = 10.0
MaxLossPerTrade = 100000
DailyLossLimit = 250000          // Higher for 24/7
MinLotSize = 0.01
MaxLotSize = 0.10
```

### Profit Optimization
```
EnableKillZone = false           // Trade all hours
LondonLotSize = 0.05
NYLotSize = 0.05
OffPeakLotSize = 0.03            // Higher off-peak

MinConfluencePoints = 5
```

### Auto-Adjustment
```
LosingStreakThreshold = 4        // More tolerance
DailyTarget1 = 350000
DailyTarget2 = 500000
DailyTarget3 = 700000
```

---

## How to Apply a Configuration

### Method 1: Manual Entry (MT4/MT5)
1. Attach EA to chart
2. In the settings dialog, go to "Inputs" tab
3. Enter values from your chosen configuration
4. Click OK

### Method 2: Save as Set File (MT4/MT5)
1. Apply configuration manually
2. In settings dialog, click "Save"
3. Name it (e.g., "Conservative.set")
4. Next time, click "Load" to apply saved settings

### Method 3: Default Settings
The EA comes with default settings optimized for 500K IDR account.
No changes needed for standard operation.

---

## Configuration Selection Guide

Choose configuration based on:

### Your Risk Tolerance
- **Conservative**: Can only afford 10-20% account risk
- **Default**: Comfortable with 20-40% account risk
- **Aggressive**: Can handle 40-60% account risk

### Your Trading Style
- **Scalping Focus**: Want quick trades, many small profits
- **Trend Following**: Prefer fewer trades with bigger wins
- **Balanced**: Mix of both (use Default)

### Your Time Availability
- **Kill Zone Only**: Can monitor during London/NY sessions
- **24/7 Trading**: Using VPS, want maximum opportunities
- **Flexible**: Use Default with kill zone enabled

### Your Account Size
- **500K-1M IDR**: Use Conservative or Default
- **1M-2M IDR**: Use Default or Aggressive
- **2M+ IDR**: Use Aggressive or custom scaled settings

---

## Testing Your Configuration

### Recommended Testing Process:
1. **Demo Account First** (1-2 weeks)
   - Apply configuration
   - Monitor daily results
   - Track win rate and drawdown

2. **Paper Trade Review** (1 week)
   - Analyze all trades
   - Check if settings work with your schedule
   - Adjust if needed

3. **Small Live Test** (1 week)
   - Start with minimum account size
   - Use Conservative configuration
   - Monitor closely

4. **Full Live Trading**
   - Scale up gradually
   - Keep monitoring performance
   - Adjust based on results

---

## Configuration Optimization Tips

1. **Start Conservative**
   - Begin with conservative settings
   - Gradually increase risk as you gain confidence

2. **Track Performance**
   - Keep a trading journal
   - Note which settings work best
   - Adjust based on data, not emotions

3. **Respect Market Conditions**
   - Trending markets: Use trend following config
   - Ranging markets: Use scalping config
   - Volatile news: Reduce lot sizes

4. **Seasonal Adjustments**
   - Different months have different volatility
   - Adjust stop loss and targets accordingly
   - Review and update quarterly

5. **Win Rate Monitoring**
   - If win rate < 50%: Increase MinConfluencePoints
   - If win rate > 80%: Decrease MinConfluencePoints
   - Target: 60-75% win rate

---

## Support

For questions about configurations:
- Check the main README.md
- Review QUICKSTART.md
- Report issues on GitHub

Remember: Past performance doesn't guarantee future results. Always test thoroughly before live trading!
